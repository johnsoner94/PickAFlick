import MySQLdb # Import the ablility to put content into a database
import urllib # Imports the ability to download files from URLs
import urllib2 # Ability to use URLS
import requests # IDK
import xlwt # Import the ability to put content into a spreadsheet
#from BeautifulSoup import BeautifulSoup # Import ability to scrape websites BeautifulSoup3
# or if you're using BeautifulSoup4:
from bs4 import BeautifulSoup # Import ability to scrape websites BeautifulSoup4

def main():
    #conn = MySQLdb.connect("localhost", "root", "i0i#ICW)oYuk", "Movies")
    getMovies()
    #conn.close()

def getMovies():

    url = 'http://www.imdb.com/chart/top?ref_=nv_wl_img_3'
    response = requests.get(url)
    html = response.content
    soup = BeautifulSoup(html)
    col = 0


    for movies in soup.findAll(attrs={"class": "titleColumn"}, limit=4):
        # Increases the column so that each movie has its own section in the database
        col = col + 1

        # Gets the information of each movies that is most easily accessible on the list of movies.
        title = movies.a.text
        print title
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
        #getRating(col, newLink) 
        #getDuration(col, newLink)
        #getGenre(col, newLink)
        #getDate(col, newLink)
        #getDirector(col, newLink)
        #getCreators(col, newLink) # PROBLEM!!! NOT DONE!!!
        #print "\n"
        #getActor(col, newLink)
        #getPoster(col, newLink, title)
        #getTags(col, newLink)
        


def getRating(col, url):
    response = requests.get(url)
    html = response.content
    soup = BeautifulSoup(html)

    # In this case limit 1 is intentional and neccessary
    for rating in soup.findAll(attrs={"itemprop": "contentRating"}, limit=1):
        rate = rating.get('content')
        print rate


def getDuration(col, url):
    response = requests.get(url)
    html = response.content
    soup = BeautifulSoup(html)

    # In this case limit 1 is intentional and neccessary
    for dur in soup.findAll(attrs={"itemprop": "duration"}, limit=1):
        duration = dur.text
        print duration


def getGenre(col, url):
    response = requests.get(url)
    html = response.content
    soup = BeautifulSoup(html)

    for gen in soup.findAll("span", attrs={"itemprop": "genre"}):
        genre = gen.text
        print genre


def getDate(col, url):
    response = requests.get(url)
    html = response.content
    soup = BeautifulSoup(html)

    # In this case limit 1 is intentional and neccessary
    for relDate in soup.findAll(attrs={"itemprop": "datePublished"}, limit=1):
        date = relDate.get('content')
        print date

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
        title = title.replace(' ', '')
        location = "Posters/" + title + ".jpg"
        print location
        urllib.urlretrieve(poster, location)
        #print poster

def getTags(col, url):
    
    url = url + "keywords"
    response = requests.get(url)
    html = response.content
    soup = BeautifulSoup(html)

    #book = xlwt.Workbook(encoding="utf-8")
    #sheet1 = book.add_sheet("Sheet 1")

    count = 0

    for tag in soup.findAll(attrs={"class": "sodatext"}, limit=1):
        count = count + 1
        print count, tag.text
        #sheet1.write(count, col, tag.text)

    #book.save("test.xls")


main()
