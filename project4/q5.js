db.laureates.aggregate([
    {$match : {"orgName" : {$exists : true}}},
    {$unwind : "$nobelPrizes"},
    {$group : {_id: "$nobelPrizes.awardYear", count : {$sum:1}}},
    {$group : {_id: "years", years: {$sum:1}}},
    {$project : {_id : 0}}
])