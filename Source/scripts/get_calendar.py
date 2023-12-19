#!/usr/bin/python3

from selenium import webdriver
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.common.by import By
from selenium.webdriver.firefox.options import Options
from selenium.webdriver.support.wait import WebDriverWait

from datetime import datetime

import function_time
import time
import sys

#   argv:
#       [1] => download path
#       [2] => domain name
#       [3] => email
#       [4] => password

if (len(sys.argv) < 4):
    print("invalid_params")
    sys.exit()

def main():
    options = Options()
    options.set_preference("browser.download.folderList", 2)
    options.set_preference("browser.download.manager.showWhenStarting", False)
    options.set_preference("browser.download.dir", sys.argv[1])
    
    options.add_argument("-headless")

    driver = webdriver.Firefox(options=options)
    driver.get(sys.argv[2])

    # waiting login page loading
    while (len(driver.find_elements(By.ID, "submitButton")) == 0):
        continue

    # find user name and password inputs in form
    user_input = driver.find_element(By.NAME, "UserName")
    pass_input = driver.find_element(By.NAME, "Password")
    
    login_button = driver.find_element(By.ID, "submitButton")

    # sending our datas
    user_input.send_keys(sys.argv[3])
    pass_input.send_keys(sys.argv[4])

    login_button.click()

    time.sleep(1)

    # check on login errors
    login_error = driver.find_elements(By.ID, "errorText")
    if (len(login_error) > 0):
        print("login_error")
        driver.close()
        sys.exit()

    # waiting page lodaing
    while (len(driver.find_elements(By.CLASS_NAME, "main-calendar-layout")) == 0):
        continue

    time.sleep(4)

    # download .ics file
    ics_download_button = driver.find_element(By.CLASS_NAME, "icon-icalendar")
    ics_download_button.click()

    # print current time
    print(datetime.now().strftime('%H:%M'))

    driver.close()

try:
    with function_time.time_limit(25):
        main()
except function_time.TimeoutException as e:
    print("time_out")
    sys.exit()