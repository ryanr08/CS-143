db.laureates.aggregate([
    {$match : {"nobelPrizes.affiliations.name.en" : "University of California"}},
    {$group : {_id: "$nobelPrizes.affiliations.city.en"}},
    {$addFields : {"loc" : {$arrayElemAt : ["$_id", 0]}}},
    {$match : {"loc" : {$size : 1}}},
    {$group : {_id: "locations", locations: {$sum:1}}},
    {$project : {_id : 0}}
])