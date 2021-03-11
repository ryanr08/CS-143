db.laureates.aggregate({$match : {"nobelPrizes.affiliations.name.en" : "CERN"}},
{$limit : 1},
{$addFields : {"Country1": {$arrayElemAt : ["$nobelPrizes.affiliations.country.en", 0]}}},
{$addFields : {"Country": {$arrayElemAt: ["$Country1", 0]}}},
{$project : {_id : 0, "Country":1}}
);