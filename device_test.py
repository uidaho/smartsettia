#!/usr/bin/python3

# requires: 
#	sudo apt install fswebcam python3 python3-pip streamer
#   sudo pip3 install --upgrade pip requests schedule uuid wget call

# to preserve the pi's SD card
#   mkdir /cameratmp
#   chmod 777 /cameratmp
# add the following to the /etc/fstab :
#   tmpfs /cameratmp tmpfs defaults,noatime,size=16m 0 0

import platform
import requests
import json
import os.path
import schedule
import time
import functools
import uuid
import threading
import subprocess

VERSION = "0.3.29"
#DOMAIN = "https://smartsettia.com/"
#DOMAIN = "http://httpbin.org/post"
DOMAIN = "https://smartsettia-backburn.c9users.io/"
MAC_ADDRESS = subprocess.check_output(["cat /sys/class/net/eth0/address"], shell=True)[:-1].decode('utf8').replace(":", "")
UUID = str(uuid.uuid5(uuid.NAMESPACE_DNS, MAC_ADDRESS))
CHALLENGE = "temppass"
TOKEN = ""
NAME = "NO NAME"
ARCH = platform.machine()
IP = subprocess.check_output(["ifconfig | grep -Eo 'inet (addr:)?([0-9]*\.){3}[0-9]*' | grep -Eo '([0-9]*\.){3}[0-9]*' | grep -v '127.0.0.1'"], shell=True)[:-1].decode('utf-8')
HOSTNAME = subprocess.check_output(["hostname"], shell=True)[:-1].decode('utf-8')
IMAGE_RATE = 10
SENSOR_RATE = 5
UPDATE_RATE = 5
COVER_STATUS = "closed"
IMAGE_PATH = "/tmp/camera.jpg"

# use tmpfs if available
if os.path.lexists("/cameratmp"):
	IMAGE_PATH = "/cameratmp/camera.jpg"

def the_time():
	"""Returns the current time in MYSQL format"""
	return time.strftime('%Y-%m-%d %H:%M:%S')

def run_threaded(job_func):
	job_thread = threading.Thread(target=job_func)
	job_thread.start()

def api_register():
	"""This registers with the smartsettia API and returns the token"""
	url = DOMAIN+"api/register"
	data = {"uuid": UUID, "challenge": CHALLENGE}
	headers = {"Content-type": "application/json", "Accept": "application/json"}
	try:
		response = requests.post(url, json=data, headers=headers)
	except requests.exceptions.RequestException as e:
		print("{}: api/register request failed: {}".format(the_time(), e))
		return
	if response.status_code in [200, 201]:
		response = response.json()
		global TOKEN
		TOKEN = response['data']['token']
		print("{}: api/register success, got token {}".format(the_time(), TOKEN))
	else:
		print("{}: api/register failed with status_code {}\n{}".format(the_time(), response.status_code, response.text))
		quit()
	return

def api_update_job():
	"""This sends a status update to the smartsettia API and returns the status code"""
	url = DOMAIN+"api/update"
	data = {
		"uuid": UUID,
		"token": TOKEN,
		"version": VERSION,
		"hostname": HOSTNAME,
		"ip": IP,
		"mac_address": MAC_ADDRESS,
		"time": the_time(),
		"cover_status": cover_status(),
		"error_msg": "",
		"limitsw_open": 0,
		"limitsw_closed": 1,
		"light_in": 0,
		"light_out": 100,
	}
	headers = {"Content-type": "application/json", "Accept": "application/json", "Authorization": "Bearer "+TOKEN}
	try:
		response = requests.post(url, json=data, headers=headers)
	except requests.exceptions.RequestException as e:
		print("{}: api/update request failed: {}".format(the_time(), e))
		return
	if response.status_code in [201]:
		response = response.json()
		global NAME, IMAGE_RATE, SENSOR_RATE, UPDATE_RATE
		if NAME != response['data']['name']:
			NAME = response['data']['name']
			print(the_time()+": Device name changed to "+NAME)
		if IMAGE_RATE != response['data']['image_rate']:
			IMAGE_RATE = response['data']['image_rate']
			schedule.clear('api_image_job')
			schedule_api_image_job()
		if SENSOR_RATE != response['data']['sensor_rate']:
			SENSOR_RATE = response['data']['sensor_rate']
			schedule.clear('api_sensor_job')
			schedule_api_sensor_job()
		if UPDATE_RATE != response['data']['update_rate']:
			UPDATE_RATE = response['data']['update_rate']
			schedule.clear('api_update_job')
			schedule_api_update_job()
		print("{}: api/update success".format(the_time()))
	else:
		print("{}: api/update failed with status_code {}\n{}".format(the_time(), response.status_code, response.text))
		time.sleep(60)
	return

def api_sensor_job():
	"""This sends a status update to the smartsettia API and returns the status code"""
	url = DOMAIN+"api/sensor"
	data = {
		"uuid": UUID,
		"token": TOKEN,
		"sensor_data": [
			{ "name": "cpu", "type": "cpu_temperature", "value": cpu_temp() },
			{ "name": "light_in", "type": "light", "value": "0.00" },
			{ "name": "light_out", "type": "light", "value": "0.00" },
			{ "name": "temperature", "type": "temperature", "value": temperature() },
			{ "name": "humidity", "type": "humidity", "value": humidity() },
			{ "name": "moisture_01", "type": "moisture", "value": "0.00" },
			{ "name": "moisture_02", "type": "moisture", "value": "0.00" },
		]
	}
	headers = {"Content-type": "application/json", "Accept": "application/json", "Authorization": "Bearer "+TOKEN}
	try:
		response = requests.post(url, json=data, headers=headers)
	except requests.exceptions.RequestException as e:
		print("{}: api/sensor request failed: {}".format(the_time(), e))
		return
	if response.status_code in [201]:
		print("{}: api/sensor success".format(the_time()))
	else:
		print("{}: api/sensor failed with status_code {}\n{}".format(the_time(), response.status_code, response.text))
		time.sleep(60)
	return

def api_image_job():
	"""This sends the webcam image to the smartsettia API"""
	webcam_capture()
	url = DOMAIN+"api/image"
	data = {"uuid": UUID, "token": TOKEN}
	files = {"image": open(IMAGE_PATH,"rb")}
	headers = {"Accept": "application/json", "Authorization": "Bearer "+TOKEN}
	try:
		response = requests.post(url, files=files, data=data, headers=headers)
	except requests.exceptions.RequestException as e:
		print("{}: api/image request failed: {}".format(the_time(), e))
		return
	if response.status_code in [200, 201]:
		print("{}: api/image success".format(the_time()))
		return
	else:
		print("{}: api/image failed with status_code {}\n{}".format(the_time(), response.status_code, response.text))
	return

def webcam_capture():
	"""Saves an image from the first connected webcam"""
	quality = "50"
	device = "/dev/video0"
	resolution = "640x480"
	fps = "10" # Our cam supports: YUYV 4:2:2 1280x720 @ 10, 960x720 @ 15, 800x600 @ 20, 640x480 @ 30
	title = NAME
	subtitle = "cpu: {} C".format(cpu_temp())
	info = UUID
	if os.path.lexists(device):
		subprocess.call(["v4lctl", "-c", device, "snap", "jpeg", resolution, IMAGE_PATH])
		#subprocess.call(["fswebcam", "--fps", fps, "--jpeg", quality, "-d", device, "-r", resolution, "--title", title, "--subtitle", subtitle, "--info", info, IMAGE_PATH])
	else:
		print("{}: capture failed, no webcam".format(the_time()))
	return

def cpu_temp():
	"""Returns the CPU temerature based on architecture"""
	if ARCH == "armv7l":
		return subprocess.check_output(["/opt/vc/bin/vcgencmd measure_temp | cut -c6-9"], shell=True)[:-1].decode('utf-8')
	else:
		return 0.0

def humidity():
	return 99.0

def temperature():
	return 99.0

def cover_status():
	return COVER_STATUS

def schedule_api_update_job():
	print("{}: Scheduling api/update every {} seconds".format(the_time(), UPDATE_RATE))
	schedule.every(UPDATE_RATE).seconds.do(api_update_job).tag('api_update_job')
	
def schedule_api_sensor_job():
	print("{}: Scheduling api/sensor every {} seconds".format(the_time(), SENSOR_RATE))
	schedule.every(SENSOR_RATE).seconds.do(run_threaded, api_sensor_job).tag('api_sensor_job')

def schedule_api_image_job():
	print("{}: Scheduling api/image every {} seconds".format(the_time(), IMAGE_RATE))
	schedule.every(IMAGE_RATE).seconds.do(run_threaded, api_image_job).tag('api_image_job')

# register first
print(the_time()+": Registering with "+DOMAIN)
api_register()

# start schedules
schedule_api_update_job()
schedule_api_sensor_job()
schedule_api_image_job()
schedule.run_all(1)

# main/scheduler loop
while True:
	schedule.run_pending()
	time.sleep(1)
