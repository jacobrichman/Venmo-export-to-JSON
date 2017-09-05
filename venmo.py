import json

with open('venmo.txt', 'r') as myfile:
    data = myfile.read().split('PUBLIC   FRIENDS   MINE', 1)[-1].split("No more payments", 1)[0]
    things = data.split('\n')
    preList = []
    theList = []
    for row in things:
        if row != "":
            preList.append(row)
            if row[0] == "+":
                theList.append(preList)
                preList = []
            if row[0] == "-":
                preList = []
    finalList=[]
    for items in theList:
        tempItems = {}
        tempItems["Name"] = items[0].split(" paid", 1)[0]
        tempItems["Description"] = items[1]
        tempItems["Date"] = items[2].split('\xc2\xb7 ', 1)[-1].split(" \xc2\xb7", 1)[0]
        if items[4] == "Leave a comment...":
            tempItems["Price"] = items[5][1:]
        else:
            tempItems["Price"] = items[4][1:]
        tempItems["Method"] = "Venmo"

        finalList.append(tempItems)

    with open('venmo_result.json', 'w') as file:
        file.write(json.dumps(finalList))
