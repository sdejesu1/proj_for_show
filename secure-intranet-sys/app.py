from collections import defaultdict

from flask import Flask, render_template, request, session, redirect, url_for
import intranet
import string
import random
import database
import hash

app = Flask(__name__)
app.secret_key = database.key_extract_db()  # Set a secret key for session security


@app.route('/')
def entrance():
    return render_template('index.html')


@app.route('/menu', methods=['GET', 'POST'])
def menu():
    if 'access_level' in session:
        access_level = session['access_level']
        welcome_message = f"Logged in as {session['username']} with access level: {access_level}"
        return render_template('userMenu.html', access_level=access_level, welcome_message=welcome_message)
    else:
        # Redirect to login if access level is not stored in the session
        return redirect(url_for('login'))


@app.route('/time_reporting', methods=['GET'])
def time_reporting():
    if 'access_level' in session:
        access_level = session['access_level']
        if (access_level == "Admin" or access_level == "Engineer" or access_level == "Accountant"
                or access_level == "Guest"):
            access_message = "You have now accessed the Time Reporting hub."
            access_granted = True
        else:
            access_message = "You are not authorized to access this area."
            access_granted = False
        return render_template('time_reporting.html', access_level=access_level,
                               access_message=access_message, access_granted=access_granted)
    else:
        # Redirect to login if access level is not stored in the session
        return redirect(url_for('login'))


@app.route('/accounting_app', methods=['GET'])
def accounting():
    if 'access_level' in session:
        access_level = session['access_level']
        if access_level == "Admin" or access_level == "Accountant":
            access_message = "You have now accessed the Accounting application."
            access_granted = True
        else:
            access_message = "You are not authorized to access this area."
            access_granted = False
        return render_template('accounting_app.html', access_level=access_level,
                               access_message=access_message, access_granted=access_granted)
    else:
        return redirect(url_for('login'))


@app.route('/it_helpdesk', methods=['GET'])
def it_help():
    if 'access_level' in session:
        access_level = session['access_level']
        if (access_level == "Admin" or access_level == "Engineer" or access_level == "Accountant"
                or access_level == "Guest"):
            access_granted = True
            access_message = "You have now accessed the IT Helpdesk."
        else:
            access_message = "You are not authorized to access this area."
            access_granted = False
        return render_template('it_helpdesk.html', access_level=access_level,
                               access_message=access_message, access_granted=access_granted)
    else:
        return redirect(url_for('login'))


@app.route('/engineering_documents', methods=['GET'])
def eng_docs():
    if 'access_level' in session:
        access_level = session['access_level']
        if access_level == "Admin" or access_level == "Engineer":
            access_granted = True
            access_message = "You have now accessed the Engineering documents."
        else:
            access_message = "You are not authorized to access this area."
            access_granted = False
        return render_template('engineering_documents.html', access_level=access_level,
                               access_message=access_message, access_granted=access_granted)
    else:
        return redirect(url_for('login'))


@app.route('/administration', methods=['GET'])
def admin():
    if 'access_level' in session:
        access_level = session['access_level']
        if access_level == "Admin":
            access_granted = True
            access_message = "You have now accessed the Administration hub."
            query_message = database.query_db()
        else:
            access_granted = False
            access_message = "You are not authorized to access this area."
            query_message = "No database query for you!"
        return render_template('administration.html', access_level=access_level,
                               access_message=access_message, query_message=query_message,
                               access_granted=access_granted)
    else:
        return redirect(url_for('login'))


# global: login attempts dictionary to keep track of login attempts
login_attempts = defaultdict(int)


# Route for user login
@app.route('/login', methods=['GET', 'POST'])
def login():
    if request.method == 'GET':
        return render_template('index.html')
    elif request.method == 'POST':
        try:
            username = request.form['username']
            password = request.form['password']

            # Perform login authentication
            access_level = intranet.login(username, password)

            if access_level:
                # Store the access level in the session
                session['username'] = username
                session['access_level'] = access_level
                # Reset login attempts upon successful login
                login_attempts[username] = 0
                return redirect(url_for('menu'))
            else:
                # Increment login attempts for the user
                login_attempts[username] += 1
                if login_attempts[username] >= 3:
                    login_attempts[username] = 0
                    return render_template('jail.html')
                else:
                    remaining_attempts = 3 - login_attempts[username]
                    return render_template('index.html',
                                           message=f"Invalid login. {remaining_attempts} attempts remaining.")
        except KeyError:
            # Handle KeyError when username or password is missing in the form data
            return "Invalid form submission. Please provide both username and password."
        except Exception as e:
            # Handle any other unexpected exceptions
            return f"An error occurred: {e}"


@app.route('/create_user', methods=['GET', 'POST'])
def create_user():
    def check_password_complexity(password):
        # Function to check password complexity
        has_digit = any(char.isdigit() for char in password)
        has_lower = any(char.islower() for char in password)
        has_upper = any(char.isupper() for char in password)
        special_chars = set("!@#$%^&*()_+}{'\";:<>?/|\\.,-[]")
        has_special = any(char in special_chars for char in password)

        return has_digit and has_lower and has_upper and has_special

    def generate_strong_password():
        while True:
            characters = string.ascii_letters + string.digits + string.punctuation
            password = ''.join(random.choice(characters) for _ in range(12))  # Generate a 12-character password
            # Password should meet complexity requirements
            if check_password_complexity(password):
                print("Your password: " + password)
                return password

    # Initializing variables for future use
    new_username = ''
    new_password = ''
    password_choice = ''

    try:
        if request.method == 'GET':
            return render_template('create_user.html')
        elif request.method == 'POST':
            new_username = request.form['username']
            password_choice = request.form['password_choice']

            # Input validation for username: check length
            if not (3 <= len(new_username) <= 15):
                error_message = "Username length should be between 3 and 15 characters."
                return render_template('create_user.html',
                                       message=error_message)

            # Input validation for username: check alphanumeric characters
            if not new_username.isalnum():
                error_message = "Username should contain only letters and numbers."
                return render_template('create_user.html',
                                       message=error_message)

        if password_choice == 'y':
            # Input validation for user-provided password
            new_password = request.form['password']
            if not (8 <= len(new_password) <= 25):
                error_message = "Password length should be between 8 and 25 characters."
                return render_template('create_user.html',
                                       message=error_message)

            # Check password complexity using the function
            if not check_password_complexity(new_password):
                error_message = ("Password should contain at least one number, one lowercase letter, one uppercase "
                                 "letter, and one special character.")

                return render_template('create_user.html',
                                       message=error_message)

        elif password_choice == 'n':
            # Generate a strong password
            new_password = generate_strong_password()

        # Once validated, hash the password
        hashed_password = hash.hash_pw(new_password)
        access_level = "Guest"
        database.add_cred(new_username, hashed_password, access_level)
        success_message = "User created successfully!"

        return render_template('create_user.html', success_message=success_message,
                               new_username=new_username, new_password=new_password, access_level=access_level)
    except KeyError as e:
        # Handle KeyError when required form data is missing
        return f"Invalid form submission: {e}"
    except Exception as e:
        # Handle other unexpected exceptions
        return f"An error occurred: {e}"


@app.route('/exit', methods=['GET'])
def exit_logout():
    # Clear the session data
    session.pop('username', None)
    session.pop('access_level', None)

    # Redirect the user to the login page or any other desired destination
    return redirect(url_for('login'))


if __name__ == "__main__":
    app.run(debug=True)
