import socket
import time
import pymysql as mariadb

# Syrus Data
# pacet format

# Open database connection

DB_NAME='syrusdb'

# Tablas dento de la base de datos, hasta ahora solo requerimos una sola
TABLES = {}

TABLES['location'] = (
    "CREATE TABLE IF NOT EXISTS `location` ("
    "  `id` int(255) NOT NULL AUTO_INCREMENT,"
    "  `latitud` varchar(15) NOT NULL,"
    "  `longitud` varchar(15) NOT NULL,"
    "  `tiempo` varchar(22) NOT NULL,"
    "  PRIMARY KEY (`id`), UNIQUE KEY `tiempo` (`tiempo`)"
    ") ENGINE=InnoDB")

# Conexión con el servidor utilizando XAMPP
cnx = mariadb.connect(host='localhost', user='mauro', password='mauro132')
cursor = cnx.cursor()

# Creación base de datos
def generate_database(curs):
    try:
        # Elimina la base de datos si ya existe
        # curs.execute("DROP DATABASE IF EXISTS {}".format(DB_NAME))
        # Crea la base de datos si no existe
        curs.execute(
            "CREATE DATABASE IF NOT EXISTS {} DEFAULT CHARACTER SET 'utf8'".format(DB_NAME))
    except mariadb.Error as err:
        print("Failed creating database: {}".format(err))
        exit(1)
    else:
        print("Database OK")

try:
    generate_database(cursor)
except mariadb.Error as err:
    print("Error: {}".format(err))

cursor.execute("USE {}".format(DB_NAME))
for name, ddl in TABLES.items():
    try:
        print("Creating table {}: ".format(name), end='')
        cursor.execute(ddl)
    except mariadb.Error as err:
        print("Failed creating table: {}".format(err))
        exit(1)
    else:
        print("Table OK")

cnx.commit()
cnx.close()

def main():
    # Create a TCP/IP socket
    sock = socket.socket(socket.AF_INET, socket.SOCK_DGRAM)
    HOST = socket.gethostbyname(socket.gethostname())
    PORT = 10
    # Bind the socket to the port

    server_address = (HOST, PORT)
    print('Inicializando en Host IPV4 %s Puerto %s' % server_address)
    sock.bind(server_address)

    while True:
        try:
            while True:
                print("Connected")
                raw_data, addr = sock.recvfrom(65535)
                save_data = str(raw_data)[2:]
                # Formato para discriminar Latitud y Longitud
                if raw_data:
                    # print('recibido ' + save_data)
                    op, evento, fecha, lat, lon = obtMsg(save_data);
                    # print(op, evento)
                    if op:
                        print('Evento: ' + str(evento) + ', ' + 'la latitud es: ' + str(lat) + ' y la longitud es: ' + str(lon))
                        print('Fecha del dato: ' + fecha)
                        # Se invoca la base de datos
                        cnx = mariadb.connect(host='localhost', user='mauro', password='mauro132')
                        cursor = cnx.cursor()
                        cursor.execute("USE {}".format(DB_NAME))
                        # Inserta los valores
                        add_location = ("INSERT INTO localiz "
                                        "(latitud, longitud, tiempo) "
                                        "VALUES (%s, %s, %s)")
                        data_location = (str(lat), str(lon), fecha)

                        # Insert new localization
                        cursor.execute(add_location, data_location)
                        cnx.commit()
                        cursor.close()
                        cnx.close()

                    else:
                        print("***********************************************")
                        print(" Mensaje Ignorado ")
                        print("***********************************************")
                else:
                    break
        finally:
            print("No se estan recibiendo más datos")

def obtMsg(d):
    # Discrimina entre el REV y RPV
    if d[0:4] == ">REV":
        op = True
        # Se utilizara para imprimir datos (como confirmación)
        evento = int(d[4:6])
        # Se almacenan los index de eventos
        fecha = obtFecha(d[6:10], d[10], d[11:16])
        # Se almacenan las fechas como un string (de una función que le hace tratamiento)
        # Coordenadas
        lat = float(d[17:19]) + (float(d[19:24]) / 100000)
        if d[16] == "-":
            lat = -lat
        lon = float(d[25:28]) + (float(d[28:33]) / 100000)
        if d[24] == "-":
            lon = -lon
    else:
        op = False
        evento = 0
        fecha = ' '
        lat = 0
        lon = 0
    return op, evento, fecha, lat, lon

def obtFecha(sem,dia,hora):
    seg = int(sem) * 7 * 24 * 60 * 60 + (int(dia) + 3657) * 24 * 60 * 60 + int(hora) + 5 * 60 * 60
    # Transforma el numero (en segundos) a un formato de fecha especificado por los %b %d %Y %M %S
    # (Vease https://docs.python.org/2/library/time.html)
    # t = time.mktime(seg)
    fecha = time.strftime("%b %d %Y %H:%M:%S", time.localtime(seg))
    return fecha

main()

