import database
import hash


# not flash version
def login(username, password):
    # how do I get a list of creds? From db.
    login_credentials = database.cred_extract_db()
    try:
        pw_hash = login_credentials[username]['password']
        isPassCorrect = hash.authenticate(pw_hash, password)
        if isPassCorrect:
            print("Password correct!")
            return login_credentials[username]['access_level']
    except KeyError:
        print("Invalid username or password!")
        return False


def main():
    database.create_db()  # this creates and initializes the db with 3 different accounts
    # database.drop_db()  # this drops the table
    # database.query_db()  # this prints the records