import sqlite3
import hash


def create_db():
    """ Create table 'credentials' in 'intranet' database and 'key' for holding the secret key """

    """
    Database table for credentials will store three values: username (any text), salted password hash (40 characters), access level 
    which is three text values: Admin, Engineer, Accountant, and Guest, where admin is top, accountant and engineer are mid
    and guest is bottom
    """

    """
    Database table for hashed key will simply store the hashed key. Purpose is to keep it in the backend for extra
    security. 
    """
    try:
        conn = sqlite3.connect('intranet.db')
        c = conn.cursor()
        c.execute('''CREATE TABLE credentials
                    (
                    username text,
                    password text,
                    access_level text
                    )''')
        conn.commit()

        c.execute('''CREATE TABLE application_key
                        (
                        hashed_key text
                        )''')
        conn.commit()
        init_db()
        return True
    except BaseException:
        return False
    finally:
        if c is not None:
            c.close()
        if conn is not None:
            conn.close()


def init_db():
    """ initializing data insert into credentials table """
    eng_user = "engineer123"
    eng_pass = hash.hash_pw("EngineerPass123!")
    eng_access = "Engineer"

    acc_user = "accountant123"
    acc_pass = hash.hash_pw("AccountantPass123!")
    acc_access = "Accountant"

    admin_user = "admin123"
    admin_pass = hash.hash_pw("AdminPass123!")
    admin_access = "Admin"

    eng_data = [(eng_user, eng_pass, eng_access)]
    acc_data = [(acc_user, acc_pass, acc_access)]
    admin_data = [(admin_user, admin_pass, admin_access)]

    """ initializing key for application """
    hashed_secret_key = hash.hash_pw("CS2660_secret_key")
    key_data = [hashed_secret_key]

    try:
        conn = sqlite3.connect('intranet.db')
        c = conn.cursor()

        c.executemany("INSERT INTO credentials VALUES (?, ?, ?)", eng_data)  # parametrized query for safety
        conn.commit()

        c.executemany("INSERT INTO credentials VALUES (?, ?, ?)", acc_data)
        conn.commit()

        c.executemany("INSERT INTO credentials VALUES (?, ?, ?)", admin_data)
        conn.commit()

        c.execute("INSERT INTO application_key VALUES (?)", key_data)
        conn.commit()

    except sqlite3.IntegrityError:
        print("Error. Tried to add duplicate record!")
    else:
        print("Data insertions for initializing: Success")
    finally:
        if c is not None:
            c.close()
        if conn is not None:
            conn.close()


def add_cred(new_username, new_password, access_level):
    """ data insert into credentials table """
    data_to_insert = [(new_username, new_password, access_level)]
    try:
        conn = sqlite3.connect('intranet.db')
        c = conn.cursor()
        c.executemany("INSERT INTO credentials VALUES (?, ?, ?)", data_to_insert)  # parametrized query for safety
        conn.commit()
    except sqlite3.IntegrityError:
        print("Error. Tried to add duplicate record!")
    else:
        print("Credential adding: Success")
    finally:
        if c is not None:
            c.close()
        if conn is not None:
            conn.close()


def authenticate_cred(username, password):
    usernameCheck = False
    passwordCheck = False
    try:
        conn = sqlite3.connect('intranet.db')
        c = conn.cursor()
        # using for loop to check each username record to see if param matches with existing record
        for row in c.execute("SELECT username FROM credentials"):
            if username == row[0]:
                usernameCheck = True
        for row in c.execute("SELECT password FROM credentials"):
            if password == row[0]:
                passwordCheck = True

        if usernameCheck and passwordCheck:
            return True
    except sqlite3.DatabaseError:
        print("Error. Could not retrieve data.")
    finally:
        if c is not None:
            c.close()
        if conn is not None:
            conn.close()


def query_db():
    """ Display all records in the intranet table """
    query_message_list = []
    try:
        conn = sqlite3.connect('intranet.db')
        c = conn.cursor()
        for row in c.execute("SELECT * FROM credentials"):
            query_message_list.append(row)
    except sqlite3.DatabaseError:
        print("Error. Could not retrieve data.")
    finally:
        if c is not None:
            c.close()
        if conn is not None:
            conn.close()

    return query_message_list


def cred_extract_db():
    """ Return a dictionary of all records in the intranet table """
    cred_dictionary = {}
    try:
        conn = sqlite3.connect('intranet.db')
        c = conn.cursor()
        c.execute("SELECT username, password, access_level FROM credentials")
        executed_rows = c.fetchall()
        cred_dictionary = {row[0]: {'password': row[1], 'access_level': row[2]} for row in executed_rows}

    except sqlite3.DatabaseError:
        print("Error. Could not retrieve data.")
    finally:
        if c is not None:
            c.close()
        if conn is not None:
            conn.close()

    return cred_dictionary


def key_extract_db():
    """ Returns secret key """
    extracted_key = ''
    try:
        conn = sqlite3.connect('intranet.db')
        c = conn.cursor()
        c.execute("SELECT hashed_key FROM application_key")
        executed_row = c.fetchone()
        extracted_key = executed_row[0]

    except sqlite3.DatabaseError:
        print("Error. Could not retrieve data.")
    finally:
        if c is not None:
            c.close()
        if conn is not None:
            conn.close()

    return extracted_key


def drop_db():
    try:
        conn = sqlite3.connect('intranet.db')
        c = conn.cursor()
        c.execute("DROP TABLE credentials")
        c.execute("DROP TABLE application_key")
    except sqlite3.DatabaseError:
        print("Error. Could not drop table.")
    finally:
        if c is not None:
            c.close()
        if conn is not None:
            conn.close()

create_db()# Run create_db function first time to create the database
#init_db()
# add_cred() # Add a credential to the database
#query_db()  # View all data stored in the database
# print(cred_extract_db())
# print(key_extract_db())
#drop_db()  # Drop the table to restart
