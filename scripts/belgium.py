#! C:\Python27\python.exe

import urllib.request
import json
import mysql.connector
from mysql.connector import Error
import os


def data_parse():
    data = ''
    with open('belgium.json') as json_file:
        data = json.load(json_file)

    #connect to db
    try:
        connection = mysql.connector.connect(host='localhost',
                                         database='showcase',
                                         user='root',
                                         password='')

        if connection.is_connected():
            db_Info = connection.get_server_info()
            print("Connected to MySQL Server version ", db_Info)
            cursor = connection.cursor()
            cursor.execute("select database();")
            record = cursor.fetchone()
            print("You're connected to database: ", record)

            delete_old_data = "DELETE from diamond_data WHERE type=1"
            cursor.execute(delete_old_data)
            connection.commit()


            mySql_insert_query = 'INSERT INTO diamond_data (stock_no, shape, weight, color, clarity, cut_grade, polish, symmetry, fluorescence_intensity, measurements, lab, memo_price, memo_discount_per,buy_price,buy_price_discount_per,cod_buy_price,cod_buy_price_discount_per,  depth_per, table_per, girdle_min, girdle_max, culet_size, crown_angle,crown_height, certificatelink,  videolink, actual_price, imagelink,vendor_id, type) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)'
            
            count = 0
            
            for p in data['Stock']:
                actual_price = 0
                if p['Buy_Price']:
                	actual_price = p['Weight']*p['Buy_Price']
                    
                fl = p['Fluorescence_Intensity']
                if p['Fluorescence_Intensity'] == 'None' or p['Fluorescence_Intensity'] == 'NA' or p['Fluorescence_Intensity'] == '' or p['Fluorescence_Intensity'] == ' ':
                    fl = 'N'

                shape = p['Shape']
                if shape=="Cushion Brilliant":
                	shape = "CUSHION"

                shape = shape.capitalize()

                val = (p['Stock_No'], shape, p['Weight'], p['Color'], p['Clarity'], p['Cut_Grade'], p['Polish'], p['Symmetry'], fl, p['Measurements'], p['Lab'], p['Memo_Price'], p['Memo_Discount_PER'], p['Buy_Price'], p['Buy_Price_Discount_PER'], p['COD_Buy_Price'], p['COD_Buy_Price_Discount_PER'], p['DEPTH_PER'], p['TABLE_PER'], p['Girdle_Min'], p['Girdle_Max'], p['Culet_Size'], p['Crown_Angle'],p['Crown_Height'], p['CertificateLink'], p['VideoLink'], actual_price, p['ImageLink'], 0, 1)
                
                count += 1
                
                if p['Buy_Price']:
                	cursor.execute(mySql_insert_query, val)
                connection.commit()
                print(count, "Record inserted successfully into Diamonds")    
            
            connection.close()
    except Error as e:
        print("Error while connecting to MySQL", e)


def check_file_size(size):
	if(size < 100):
		hit_api()
	else:
		data_parse()

def hit_api():
	url = "https://belgiumny.com/api/DeveloperAPI?stock=&APIKEY=B6F7AD04-70D4-28EF-B548-64A2DC8D4FFD"
	response = urllib.request.urlopen(url)
	res = response.read()
	f = open("belgium.json", "wb")
	f.truncate(0)
	f.write(res)
	f.close()
	size = os.stat('belgium.json').st_size
	check_file_size(size)



hit_api()
