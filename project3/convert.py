import json

#recursive function to loop through json dictionary and extract each element into proper dictionary
def extract_json(parent):
    for new_key in parent:
        if (new_key == "prizeAmount"):
            new_prize['prizeAmount'] = parent[new_key]
        if (type(parent[new_key]) == type(str())):
            if (new_key in new_laureate.keys()):
                if (new_laureate[new_key] == "NULL"):
                    new_laureate[new_key] = '"' + parent[new_key] + '"'
            if(new_key in new_prize.keys()):
                new_prize[new_key] = '"' + parent[new_key] + '"'
            #if (new_key in new_org.keys()):
                #new_org[new_key] = parent[new_key]
        elif (type(parent[new_key]) == type(dict())):
            if ('en' in parent[new_key].keys()):
                if (";" not in parent[new_key]['en']):
                    if (new_key in new_laureate.keys()):
                        if (new_laureate[new_key] == "NULL"):
                            new_laureate[new_key] = '"' + parent[new_key]['en'] + '"'
                    if (new_key in new_prize.keys()):
                        new_prize[new_key] = '"' + parent[new_key]['en'] + '"'
                    #if (new_key in new_org.keys()):
                        #new_org[new_key] = parent[new_key]['en']
            else:
                extract_json(parent[new_key])
        elif (type(parent[new_key]) == type(list())):
            for new_key2 in parent[new_key]:
                extract_json(new_key2)


f = open('/home/cs143/data/nobel-laureates.json',)
data = json.load(f)

laureates = []
nobelPrizes = []
#organiations = []

for key in data["laureates"]:
    new_laureate = {"id": "NULL", "givenName": "NULL", "familyName": "NULL", "gender": "NULL", "orgName": "NULL", "date": "NULL", "city": "NULL", "country": "NULL"}
    new_prize = {"id": "NULL", "awardYear": "NULL", "category": "NULL", "sortOrder": "NULL", "portion": "NULL", 
            "dateAwarded": "NULL", "prizeStatus": "NULL", "motivation": "NULL", "prizeAmount": "NULL", "name": "NULL", "city": "NULL", "country": "NULL"}
    #new_org = {"id": "NULL", "orgName": "NULL", "date": "NULL", "city": "NULL", "country": "NULL"}

    extract_json(key)
    if (new_laureate['date'] == "NULL"):
        new_laureate['date'] = "0000-00-00"

    if (new_laureate not in laureates):
        laureates.append(new_laureate)
    if (new_prize not in nobelPrizes):
        nobelPrizes.append(new_prize)
    #if ((new_org not in organiations) and (new_org['orgName'] != "NULL")):
        #organiations.append(new_org)

f1 = open("./Laureates.del", "w")

for item in laureates:
    for x in item:
        if (x == "country"):
            f1.write(f"{item[x]}")
        else:          
            f1.write(f"{item[x]};")
    f1.write("\n")

f2 = open("./NobelPrizes.del", "w")

for item in nobelPrizes:
    for x in item:
        if (x == "country"):
            f2.write(f"{item[x]}")
        else:          
            f2.write(f"{item[x]};")
    f2.write("\n")

f2.close()
f1.close()
f.close()
