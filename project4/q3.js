db.laureates.aggregate([
    {$group : {_id: "$familyName.en", count: {$sum:1}}},
    {$match : {count : {$gt : 4}}},
    {$addFields : {"familyName" : "$_id"}},
    {$sort : {"familyName" : -1}},
    {$limit : 2},
    {$project : {_id : 0, "familyName" : 1}}
])