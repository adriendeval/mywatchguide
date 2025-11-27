from flask import Flask, redirect
import sqlite3
import requests

app = Flask(__name__)
TMDB_KEY = "TA_CLE_API_TMBD_ICI"

def get_db():
    conn = sqlite3.connect("db.sqlite3")
    conn.row_factory = sqlite3.Row
    return conn

@app.route("/")
def index():
    conn = get_db()
    films = conn.execute("SELECT * FROM films ORDER BY id DESC").fetchall()
    return f"Tu as {len(films)} films dans ta base."

@app.route("/add_movie/<tmdb_id>")
def add_movie(tmdb_id):
    r = requests.get(
        f"https://api.themoviedb.org/3/movie/{tmdb_id}",
        params={"api_key": TMDB_KEY, "language": "fr-FR"}
    )
    data = r.json()

    conn = get_db()
    conn.execute(
        "INSERT INTO films (tmdb_id, titre) VALUES (?, ?)",
        (tmdb_id, data["title"])
    )
    conn.commit()

    return redirect("/")

if __name__ == "__main__":
    app.run(debug=True)
