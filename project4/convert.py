import json

# load data
data = json.load(open("/home/cs143/data/nobel-laureates.json", "r"))

f = open("./laureates.import", 'w')

#for every laureate, write the JSON object to laureate.import followed by a newline
for item in data["laureates"]:
    laur = json.dumps(item)
    f.write(laur)
    f.write("\n")
f.close()
