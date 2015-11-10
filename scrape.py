import psycopg2 # Imports access to database
import urllib # Imports the ability to download files from URLs
import urllib2 # Ability to use URLS
import requests # IDK
#from datetime import datetime ## If you insist on getting release date to work, then use this.
from BeautifulSoup import BeautifulSoup # Import ability to scrape websites BeautifulSoup3
# or if you're using BeautifulSoup4:
#from bs4 import BeautifulSoup # Import ability to scrape websites BeautifulSoup4 caused error


NULL = None

try:
    conn = psycopg2.connect("dbname='template1' user='' host='localhost'")
except:
    print "I am unable to connect to the database"

cur = conn.cursor()


def main():
    # Deletes table
    #cur.execute("DROP TABLE movTest")
    # Create table with release date
    #cur.execute("CREATE TABLE movTest (id serial PRIMARY KEY, title varchar(255), year int, rating varchar(10), duration int, genre varchar(255), date date, poster varchar(255), directors varchar(255), creators varchar(255), actors varchar(255), tags varchar(255));")
    # Create table without release date
    #cur.execute("CREATE TABLE movTest (id serial PRIMARY KEY, title varchar(255), year int, rating varchar(10), duration int, genre varchar(255), poster varchar(255), directors varchar(255), creators varchar(255), actors varchar(255), tags varchar(255));")

    #cur.execute("CREATE TABLE test (id serial PRIMARY KEY, num integer, data varchar);")
    #cur.execute("INSERT INTO test (num, data) VALUES (%s, %s)", (100, "abc'def"))
    
    #getMovies()

    conn.commit()

    printTable()


def printTable():

    cur.execute("SELECT * FROM movTest;")
    rows = cur.fetchall()

    for row in rows:
        print row
    

def getMovies():

    url = 'http://www.imdb.com/chart/top?ref_=nv_wl_img_3'
    response = requests.get(url)
    html = response.content
    soup = BeautifulSoup(html)
    col = 0


    for movies in soup.findAll(attrs={"class": "titleColumn"}, limit=50):
        # Increases the column so that each movie has its own section in the database
        col = col + 1

        # Gets the information of each movies that is most easily accessible on the list of movies.
        title = movies.a.text
        print col, title
        year = movies.span.text
        year = year[1:5]
        #print year


        # Gets the new URL for each movie.
        newLink = (movies.a.get('href'))
        newLink = newLink[:17]
        newLink = "http://www.imdb.com" + newLink
        #print newLink
        
        # These call the methods that have to access the information in different parts of the movie's
        # individual page.
        rating = getRating(col, newLink) 
        dur = getDuration(col, newLink)
        #getGenre(col, newLink)
        #date = getDate(col, newLink)
        #print date
        #getDirector(col, newLink)
        #getCreators(col, newLink) # PROBLEM!!! NOT DONE!!!
        #print "\n"
        #getActor(col, newLink)
        poster = getPoster(col, newLink, title)
        #print poster
        #getTags(col, newLink)


        try:
            cur.execute("INSERT INTO movTest (title, year, rating, duration, genre, poster, directors, creators, actors, tags) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", (title, year, rating, dur, NULL, poster, NULL, NULL, NULL, NULL))
        except:
            print "Error adding movie to database"
        


def getRating(col, url):
    response = requests.get(url)
    html = response.content
    soup = BeautifulSoup(html)

    # In this case limit 1 is intentional and neccessary
    for rating in soup.findAll(attrs={"itemprop": "contentRating"}, limit=1):
        rate = rating.get('content')
        #print rate
        return rate


def getDuration(col, url):
    response = requests.get(url)
    html = response.content
    soup = BeautifulSoup(html)

    # In this case limit 1 is intentional and neccessary
    for dur in soup.findAll(attrs={"itemprop": "duration"}, limit=1):
        duration = dur.text
        duration = duration.rstrip(" min")
        #print duration
        return duration


def getGenre(col, url):
    response = requests.get(url)
    html = response.content
    soup = BeautifulSoup(html)

    for gen in soup.findAll("span", attrs={"itemprop": "genre"}):
        genre = gen.text
        print genre

# No, I don't like this. It's not working.
def getDate(col, url):
    response = requests.get(url)
    html = response.content
    soup = BeautifulSoup(html)

    # In this case limit 1 is intentional and neccessary
    for relDate in soup.findAll(attrs={"itemprop": "datePublished"}, limit=1):
        date = relDate.get('content')
        #print date
        return date

def getDirector(col, url):
    response = requests.get(url)
    html = response.content
    soup = BeautifulSoup(html)

    # In this case limit 1 is intentional and neccessary
    for direct in soup.findAll(attrs={"itemprop": "director"}):
        director = direct.a.text
        print director

# PROBLEM!!! NOT DONE!!!
def getCreators(col, url):
    response = requests.get(url)
    html = response.content
    soup = BeautifulSoup(html)

    for create in soup.findAll("div", attrs={"itemprop": "creator"}):
        creator = create.span.text
        print creator
    
# Right now it only returns the top 15 actors in the movie.
def getActor(col, url):
    response = requests.get(url)
    html = response.content
    soup = BeautifulSoup(html)
    

    count = 0

    
    for stars in soup.findAll(attrs={"itemprop": "actor"}):
        count = count + 1
        actor = stars.text
        print count, actor


# Right now this function downloads the poster. Could source the URL file instead.
def getPoster(col, url, title):
    response = requests.get(url)
    html = response.content
    soup = BeautifulSoup(html)
    
    for img in soup.findAll("img", attrs={"height": "317"}):
        poster = img.get("src")
        #title = title.replace(' ', '')
        #location = "Posters/" + title + ".jpg"
        #print location
        #urllib.urlretrieve(poster, location)
        #print poster
        return poster
        

def getTags(col, url):
    
    url = url + "keywords"
    response = requests.get(url)
    html = response.content
    soup = BeautifulSoup(html)



    count = 0

    for tag in soup.findAll(attrs={"class": "sodatext"}, limit=1):
        count = count + 1
        print count, tag.text
        #(count, col, tag.text)



main()
cur.close()
conn.close()
