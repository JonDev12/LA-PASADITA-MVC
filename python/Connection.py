from mysql.connector import *

class Connection:
    def __init__(self):
        self.__conn = connect(host='localhost', user='root', password='', database='db_pasadita')
        self.__cursor = self.__conn.cursor()
    
    