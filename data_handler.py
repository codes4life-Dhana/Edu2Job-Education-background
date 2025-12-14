import sqlite3

def register_user(email, password, name):
    conn = sqlite3.connect("edu2job.db")
    cursor = conn.cursor()
    cursor.execute("INSERT INTO users (email, password, name) VALUES (?, ?, ?)", (email, password, name))
    conn.commit()
    conn.close()
    print("✅ New user added successfully!")

def verify_user(email, password):
    conn = sqlite3.connect("edu2job.db")
    cursor = conn.cursor()
    cursor.execute("SELECT * FROM users WHERE email = ? AND password = ?", (email, password))
    user = cursor.fetchone()
    conn.close()
    if user:
        print(f"✅ Login successful! Welcome, {user[3]}")
        return True
    else:
        print("❌ Invalid credentials.")
        return False

def view_all_users():
    conn = sqlite3.connect("edu2job.db")
    cursor = conn.cursor()
    cursor.execute("SELECT * FROM users")
    data = cursor.fetchall()
    conn.close()
    print("📋 Registered Users:")
    for row in data:
        print(row)

# --- Example test ---
if __name__ == "__main__":
    print("Testing SQLite user functions:")
    view_all_users()