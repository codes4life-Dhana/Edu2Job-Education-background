import sqlite3

# connect or create database
conn = sqlite3.connect("edu2job.db")
cursor = conn.cursor()

# create users table
cursor.execute('''CREATE TABLE IF NOT EXISTS users (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    name TEXT NOT NULL,
                    email TEXT UNIQUE NOT NULL,
                    password TEXT NOT NULL
                )''')

conn.commit()
print("✅ Database and table created successfully!")

# insert demo data (optional)
cursor.execute("INSERT OR IGNORE INTO users (name, email, password) VALUES (?, ?, ?)", 
               ("Dhanasri", "dhanasri@gmail.com", "12345"))
conn.commit()
print("✅ Sample user added")

conn.close()