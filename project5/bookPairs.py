# set up SparkContext for BookCount application
from pyspark import SparkContext
sc = SparkContext("local", "BookCount")

# function to get pairs of books from list of books (from a single user)
def get_book_pairs(lst):
    books = lst.split(",")
    pairs = []
    for i in range(0, len(books)):
        for j in range(i+1, len(books)):
            pairs.append((int(books[i]), int(books[j])))
    return pairs


# the main map-reduce task
lines = sc.textFile("/home/cs143/data/goodreads.user.books")
book_lists = lines.map(lambda line: line[line.index(":")+1:])
book_pairs = book_lists.flatMap(get_book_pairs)
book_pair_counts1 = book_pairs.map(lambda pair: (pair, 1))
book_pair_counts2 = book_pair_counts1.reduceByKey(lambda a, b: a + b)
book_pair_counts3 = book_pair_counts2.filter(lambda count_pair: count_pair[1] > 20)
book_pair_counts3.saveAsTextFile("output")