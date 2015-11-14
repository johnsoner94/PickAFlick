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
    
    # Create table with release date
    #cur.execute("CREATE TABLE movTest (id serial PRIMARY KEY, title varchar(255), year int, rating varchar(10), duration int, genre varchar(255), date date, poster varchar(255), directors varchar(255), creators varchar(255), actors varchar(255), tags varchar(255));")
    # Create table without release date
    #cur.execute("CREATE TABLE movTest (id serial PRIMARY KEY, title varchar(255), year int, rating varchar(10), duration int, genre varchar(255), poster varchar(255), directors varchar(255), creators varchar(255), actors varchar(255), tags varchar(255));")

    #cur.execute("CREATE TABLE test2 (id serial PRIMARY KEY, num integer, data varchar);")
    #cur.execute("INSERT INTO test2 (num, data) VALUES (%s, %s)", (100, "abc'def"))
    #deleteTable("test2")

    getMovies()

    conn.commit()

    #Give the name of the table and will print it.
    #printTable("test2")

def deleteTable(table):
    # Deletes table
    command = "DROP TABLE " + table
    cur.execute(command)
    


def printTable(table):
    command = "SELECT * FROM " + table + ";"
    try:
        cur.execute(command)
    except:
        print "Cannot find table."
        return

    rows = cur.fetchall()

    for row in rows:
        print row
    

def getMovies():

    url = 'http://www.imdb.com/chart/top?ref_=nv_wl_img_3'
    response = requests.get(url)
    html = response.content
    soup = BeautifulSoup(html)
    col = 0


    for movies in soup.findAll(attrs={"class": "titleColumn"}, limit=1):
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
        #rating = getRating(col, newLink) 
        #dur = getDuration(col, newLink)
        #poster = getPoster(col, newLink, title)
        #print poster


##        try:
##            cur.execute("INSERT INTO movTest (title, year, rating, duration, poster) VALUE, %s, %s, %s, %s)", (title, year, rating, dur, poster))
##        except:
##            print "Error adding movie to database"

        #if col == 6:
        getTags(newLink, title, "movTest", "tagTest")
        

## Parameter: Get the movie ID, Movie URL
## TODO:      - See if the tag already exists, if so put the movie in the TAG_NAME table
##            - If not, create a new tag with TAG_NAME_ID, TAG_NAME, TAG_TYPE, and MOVIE_ID
def getTags(newLink, title, tableMovie, tableTag):
    ##SELECT column_name FROM table_name;
    if title.find("'") > -1:
        return
    title = "\'" + title + "\'"
    command = "SELECT * FROM movTest WHERE title = " + title + ";"
    #print command
    try:
        cur.execute(command)
    except:
        print "Cannot find column."
        return

    rows = cur.fetchall()


    for row in rows:
        movie_ID = row[0]
        #print movie_ID


##    command = "SELECT * FROM tagTest WHERE movie_ID = ", movie_ID, ";"
##
##    try:
##        cur.execute(command)
##    except:
##        print "Make new tag add the movie id"
    getGenre(movie_ID, newLink, title, "tagTest")
##        return

    
    #getDirector(col, newLink)
    #getCreators(col, newLink) # PROBLEM!!! NOT DONE!!!
    #print "\n"
    #getActor(col, newLink)
    #getKeywords(col, newLink)

def getRating(col, url):
    response = requests.get(url)
    html = response.content
    soup = BeautifulSoup(html)
    
    # In this case limit 1 is intentional and neccessary
    for rating in soup.findAll(attrs={"itemprop": "contentRating"}, limit=1):
        rate = rating.get('content')
##        print rate
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


# Right now this function sources the URL file. Could downloads the poster instead.
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
        
 
# Add as a type of tag
def getGenre(movie_ID, url, title, tableTag):
    response = requests.get(url)
    html = response.content
    soup = BeautifulSoup(html)

    for gen in soup.findAll("span", attrs={"itemprop": "genre"}):
        genre = gen.text
        genre = "\'" + genre + "\'"
        print genre


        command = ("SELECT CASE WHEN EXISTS (SELECT * FROM tagTest WHERE name = " + genre + ") THEN CAST(1 AS BIT) ELSE CAST(0 AS BIT) END;")
        print command

        try:
            cur.execute(command)
            result = cur.fetchall()[0]
            exists = result[0]
            exists = int(exists)
        except:
            print "Command failed"
            


        if exists == 0:
            print "Doesn't exist"
            command = "INSERT INTO tagTest (name, type) VALUES (%s, %s);", (genre, 'genre')
            print command
            try:
                print ":)"
                #cur.execute(command)
            except:
                print ":("
        else:
            print "Does exist"
            command = "SELECT * FROM tagTest WHERE name = " + genre + ";"
            #print command
            try:
                cur.execute(command)
            except:
                print "Cannot find column."
            return

            rows = cur.fetchall()

            for row in rows:
                tag_ID = row[0]
                
            command = "INSERT INTO pairingTest (tag_ID, movie_ID) VALUES (%s, %s);", (tag_ID, movie_ID)
            print command
            try:
                cur.execute(command)
            except:
                print ":("



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
        

def getKeywords(col, url):
    
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


## DUMP CODE
## Not sure this one is worth it.
#date = getDate(col, newLink)
#print date

# No, I don't like this. It's not working.
##def getDate(col, url):
##    response = requests.get(url)
##    html = response.content
##    soup = BeautifulSoup(html)
##
##    # In this case limit 1 is intentional and neccessary
##    for relDate in soup.findAll(attrs={"itemprop": "datePublished"}, limit=1):
##        date = relDate.get('content')
##        #print date
##        return date
