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
    getMovies()
    
    conn.commit()


def getMovies():

    url = 'http://www.imdb.com/chart/top?ref_=nv_wl_img_3'
    response = requests.get(url)
    html = response.content
    soup = BeautifulSoup(html)
    col = 0


    for movies in soup.findAll(attrs={"class": "titleColumn"}):
        # Increases the column so that each movie has its own section in the database
        col = col + 1

        # Gets the information of each movies that is most easily accessible on the list of movies.
        title = movies.a.text
        title = title.replace("'", "''");

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
        #getPoster(col, newLink, title)
        #poster = getPoster(col, newLink, title)
        #print poster


##        try:
##            cur.execute("INSERT INTO movTest (title, year, rating, duration, poster) VALUE, %s, %s, %s, %s)", (title, year, rating, dur, poster))
##        except:
##            print "Error adding movie to database"

        #if col == 6:
        getTags(newLink, title, "movTest", "tagTest")
        

## Parameter: Get the movie ID, Movie URL
def getTags(newLink, title, tableMovie, tableTag):
    ##SELECT column_name FROM table_name;
    title = str(title)
    title = "'" + title + "'"
    command = "SELECT * FROM movTest WHERE title = " + title + ";"
    try:
        cur.execute(command)
    except:
        print "Cannot find column in the movie database."
        print "Command that didn't work: " + command
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
    getDirector(movie_ID, newLink, title, "tagTest")
    getCreators(movie_ID, newLink, title, "tagTest")
    #print "\n"
    getActor(movie_ID, newLink, title, "tagTest")
    getKeywords(movie_ID, newLink, title, "tagTest")

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
        title = title.replace(' ', '')
        location = "Posters/" + title + ".jpg"
        #print location
        #urllib.urlretrieve(poster, location)
        #print poster
        #return location
        col = str(col)
        #location = location.replace("'", "''")
        location = "'" + location + "'"
        command = ("UPDATE movtest SET poster = " + location + " WHERE id = " + col + ";")
        try:
            print command
            #cur.execute(command)
        except:
            print "Command failed, update poster url"
            return
        
        
 
# Add as a type of tag
def getGenre(movie_ID, url, title, tableTag):
    response = requests.get(url)
    html = response.content
    soup = BeautifulSoup(html)

    for gen in soup.findAll("span", attrs={"itemprop": "genre"}):
        genre = gen.text
        genre = genre.replace("'", "''")
        genre = "'" + genre + "'"
        command = ("SELECT CASE WHEN EXISTS (SELECT * FROM tagTest WHERE name = " + genre + ") THEN CAST(1 AS BIT) ELSE CAST(0 AS BIT) END;")

        try:
            cur.execute(command)
            result = cur.fetchall()[0]
            exists = result[0]
            exists = int(exists)
        except:
            print "Command failed, genre"
            return
            
        if exists == 0:
            genre = genre[1: -1]
            genre = str(genre)
            try:
                cur.execute("INSERT INTO tagTest (name, type) VALUES (%s, %s);", (genre, 'genre'))
                genre = "'" + genre + "'"
                command = "SELECT * FROM tagTest WHERE name = " + genre + ";"
                cur.execute(command)
            except:
                print "Adding the tag to the database didn't work"
                print command
                return
        else:
            command = "SELECT * FROM tagTest WHERE name = " + genre + ";"
            try:
                cur.execute(command)
            except:
                print "Cannot find column in the tag database."
                return

        rows = cur.fetchall()

        for row in rows:
            tag_ID = row[0]
                
        tag_ID = str(tag_ID)
        movie_ID = str(movie_ID)
        command = ("SELECT CASE WHEN EXISTS (SELECT * FROM pairingTest WHERE tag_ID = " + tag_ID + " AND movie_ID = " + movie_ID + ") THEN CAST(1 AS BIT) ELSE CAST(0 AS BIT) END;")
        
        try:
            cur.execute(command)
            result = cur.fetchall()[0]
            exists = result[0]
            exists = int(exists)
            command = ("SELECT CASE WHEN EXISTS (SELECT * FROM tagTest WHERE name = " + genre + ") THEN CAST(1 AS BIT) ELSE CAST(0 AS BIT) END;")
            if exists == 0:
                try:
                    command = ("INSERT INTO pairingTest (tag_ID, movie_ID) VALUES (" + tag_ID + ", " + movie_ID + ");")
                    cur.execute(command)
                except:
                    print "Error adding genre pair: " + command
            else:
                return
        except:
            command = str(command)
            print "Error checking for genre pair: " + command



def getDirector(movie_ID, url, title, tableTag):
    response = requests.get(url)
    html = response.content
    soup = BeautifulSoup(html)

    # In this case limit 1 is intentional and neccessary
    for direct in soup.findAll(attrs={"itemprop": "director"}):
        director = direct.a.text
        director = director.replace("'", "''")
        director = "'" + director + "'"
        command = ("SELECT CASE WHEN EXISTS (SELECT * FROM tagTest WHERE name = " + director + ") THEN CAST(1 AS BIT) ELSE CAST(0 AS BIT) END;")
        try:
            cur.execute(command)
            result = cur.fetchall()[0]
            exists = result[0]
            exists = int(exists)
        except:
            print "Command failed, director"
            return

        if exists == 0:
            director = director[1: -1]
            director = str(director)
            try:
                cur.execute("INSERT INTO tagTest (name, type) VALUES (%s, %s);", (director, 'director'))
                director = "'" + director + "'"
                cur.execute("SELECT * FROM tagTest WHERE name = " + director + ";")
            except:
                print "Adding the tag to the database didn't work"
        else:
            command = "SELECT * FROM tagTest WHERE name = " + director + ";"
            try:
                cur.execute(command)
            except:
                print "Cannot find column."
                return

        rows = cur.fetchall()

        for row in rows:
            tag_ID = row[0]

        tag_ID = str(tag_ID)
        movie_ID = str(movie_ID)
        command = ("SELECT CASE WHEN EXISTS (SELECT * FROM pairingTest WHERE tag_ID = " + tag_ID + " AND movie_ID = " + movie_ID + ") THEN CAST (1 AS BIT) ELSE CAST(0 AS BIT) END;")
        try:
            cur.execute(command)
            result = cur.fetchall()[0]
            exists = result[0]
            exists = int(exists)

            if exists == 0:
                try:
                    command = ("INSERT INTO pairingTest (tag_ID, movie_ID) VALUES (" + tag_ID + ", " + movie_ID + ");")
                    cur.execute(command)
                except:
                    print "Error adding director pair: " + command
            else:
                return
        except:
            print "Error checking for directoring pair: " + command



# There's an error in the logic. If a name has already been added as a tag under one category, it is not readded under the new category. (ie Frank Darabont is both a director
# and a writter for The Shawshank Redemption, but he'll only be credited as a writer.) If I were to fix this method, I think all of the other methods would have to be modified
# to be able to be cross referenced.
def getCreators(movie_ID, url, title, tableTag):
    response = requests.get(url)
    html = response.content
    soup = BeautifulSoup(html)

    for create in soup.findAll("span", attrs={"itemprop": "name"}):
        prev = ""
        names = create.parent.parent.attrs
        for writers in names:
            check = str(writers[1])
            if prev == "txt-block":
                if "creator" == check:
                    creator = create.text
                    creator = creator.replace("'", "''")
                    creator = "'" + creator + "'"
                    command = ("SELECT CASE WHEN EXISTS (SELECT * FROM tagTest WHERE name = " + creator + ") THEN CAST(1 AS BIT) ELSE CAST(0 AS BIT) END;")
                    try:
                        cur.execute(command)
                        result = cur.fetchall()[0]
                        exists = result[0]
                        exists = int(exists)
                    except:
                        print "Command failed, creator"

                    if exists == 0:
                        creator = str(creator)
                        creator = creator[1: -1]
                        try:
                            cur.execute("INSERT INTO tagTest (name, type) VALUES (%s, %s);", (creator, 'creator'))
                            creator = "'" + creator + "'"
                            cur.execute("SELECT * FROM tagTest WHERE name = " + creator + ";")
                        except:
                            print "Adding the tag to the database didn't work"
                    else:
                        command = "SELECT * FROM tagTest WHERE name = " + creator + ";"
                        try:
                            cur.execute(command)
                        except:
                            print "Cannot find column."

                    rows = cur.fetchall()

                    for row in rows:
                        tag_ID = row[0]

                    tag_ID = str(tag_ID)
                    movie_ID = str(movie_ID)
                    command = ("SELECT CASE WHEN EXISTS (SELECT * FROM pairingTest WHERE tag_ID = " + tag_ID + " AND movie_ID = " + movie_ID + ") THEN CAST (1 AS BIT) ELSE CAST(0 AS BIT) END;")
                    try:
                        cur.execute(command)
                        result = cur.fetchall()[0]
                        exists = result[0]
                        exists = int(exists)

                        if exists == 0:
                            try:
                                command = ("INSERT INTO pairingTest (tag_ID, movie_ID) VALUES (" + tag_ID + ", " + movie_ID + ");")
                                cur.execute(command)
                            except:
                                print "Error adding creator pair: " + command
                        else:
                            print "Does exist"
                    except:
                        print "Error checking for creating pair: " + command
            prev = check
    
# Right now it only returns the top 15 actors in the movie.
def getActor(movie_ID, url, title, tableTag):
    response = requests.get(url)
    html = response.content
    soup = BeautifulSoup(html)

    count = 0

    
    for stars in soup.findAll(attrs={"itemprop": "actor"}):
        count = count + 1
        actor = stars.text
        actor = actor.replace("'", "''")
        actor = "'" + actor + "'"
        command = ("SELECT CASE WHEN EXISTS (SELECT * FROM tagTest WHERE name = " + actor + ") THEN CAST(1 AS BIT) ELSE CAST(0 AS BIT) END;")

        try:
            cur.execute(command)
            result = cur.fetchall()[0]
            exists = result[0]
            exists = int(exists)
        except:
            print "Command failed, actor: " + command
            return

        if exists == 0:
            actor = actor[1: -1]
            try:
                actor = str(actor)
            except:
                print actor
            try:
                cur.execute("INSERT INTO tagTest (name, type) VALUES (%s, %s);", (actor, 'actor'))
                actor = "'" + actor + "'"
                cur.execute("SELECT * FROM tagTest WHERE name = " + actor + ";")
            except:
                print "Adding the tag to the database didn't work"
        else:
            command = "SELECT * FROM tagTest WHERE name = " + actor + ";"
            try:
                cur.execute(command)
            except:
                print "Cannot find column: " + command
                return
    
        rows = cur.fetchall()

        for row in rows:
            tag_ID = row[0]

        tag_ID = str(tag_ID)
        movie_ID = str(movie_ID)
        command = ("SELECT CASE WHEN EXISTS (SELECT * FROM pairingTest WHERE tag_ID = " + tag_ID + " AND movie_ID = " + movie_ID + ") THEN CAST (1 AS BIT) ELSE CAST(0 AS BIT) END;")
        try:
            cur.execute(command)
            result = cur.fetchall()[0]
            exists = result[0]
            exists = int(exists)

            if exists == 0:
                try:
                    command = ("INSERT INTO pairingTest (tag_ID, movie_ID) VALUES (" + tag_ID + ", " + movie_ID + ");")
                    cur.execute(command)
                except:
                    print "Error adding actor pair: " + command
            else:
                return
        except:
            print "Error checking for actor pair: " + command
        

def getKeywords(movie_ID, url, title, tableTag):
    
    url = url + "keywords"
    response = requests.get(url)
    html = response.content
    soup = BeautifulSoup(html)



    count = 0

    for tag in soup.findAll(attrs={"class": "sodatext"}):
        count = count + 1
        tag = str(tag.text)
        tag = tag.replace("'", "''")
        tag = "'" + tag + "'"
        command = ("SELECT CASE WHEN EXISTS (SELECT * FROM tagTest WHERE name = " + tag + ") THEN CAST(1 AS BIT) ELSE CAST(0 AS BIT) END;")
        try:
            cur.execute(command)
            result = cur.fetchall()[0]
            exists = result[0]
            exists = int(exists)
        except:
            print "Command failed, keywords"
            print command
            return

        if exists == 0:
            tag = tag[1: -1]
            tag = str(tag)
            try:
                cur.execute("INSERT INTO tagTest (name, type) VALUES (%s, %s);", (tag, 'keyword'))
                tag = "'" + tag + "'"
                cur.execute("SELECT * FROM tagTest WHERE name = " + tag + ";")
            except:
                print "Adding the tag to the database didn't work"
                return
        else:
            command = "SELECT * FROM tagTest WHERE name = " + tag + ";"
            try:
                cur.execute(command)
            except:
                print "Cannot find column."
                return

        rows = cur.fetchall()

        for row in rows:
            tag_ID = row[0]

        tag_ID = str(tag_ID)
        movie_ID = str(movie_ID)
        command = ("SELECT CASE WHEN EXISTS (SELECT * FROM pairingTest WHERE tag_ID = " + tag_ID + " AND movie_ID = " + movie_ID + ") THEN CAST (1 AS BIT) ELSE CAST(0 AS BIT) END;")
        try:
            cur.execute(command)
            result = cur.fetchall()[0]
            exists = result[0]
            exists = int(exists)

            if exists == 0:
                try:
                    command = ("INSERT INTO pairingTest (tag_ID, movie_ID) VALUES (" + tag_ID + ", " + movie_ID + ");")
                    cur.execute(command)
                except:
                    print "Error adding keword pair: " + command
                    return
            else:
                return
        except:
            print "Error checking for keyword pair: " + command
            return



main()
cur.close()
conn.close()


## DUMP CODE

# Create table with release date
#cur.execute("CREATE TABLE movTest (id serial PRIMARY KEY, title varchar(255), year int, rating varchar(10), duration int, genre varchar(255), date date, poster varchar(255), directors varchar(255), creators varchar(255), actors varchar(255), tags varchar(255));")
# Create table without release date
#cur.execute("CREATE TABLE movTest (id serial PRIMARY KEY, title varchar(255), year int, rating varchar(10), duration int, genre varchar(255), poster varchar(255), directors varchar(255), creators varchar(255), actors varchar(255), tags varchar(255));")

#cur.execute("CREATE TABLE test2 (id serial PRIMARY KEY, num integer, data varchar);")
#cur.execute("INSERT INTO test2 (num, data) VALUES (%s, %s)", (100, "abc'def"))
#deleteTable("test2")

#Give the name of the table and will print it.
#printTable("test2")

##def deleteTable(table):
##    # Deletes table
##    command = "DROP TABLE " + table
##    cur.execute(command)
##    
##
##
##def printTable(table):
##    command = "SELECT * FROM " + table + ";"
##    try:
##        cur.execute(command)
##    except:
##        print "Cannot find table."
##        return
##
##    rows = cur.fetchall()
##
##    for row in rows:
##        print row


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
