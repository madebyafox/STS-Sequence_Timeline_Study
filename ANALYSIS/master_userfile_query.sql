SELECT 
users.id as id,
users.session as sess,
d.gender as gender,
d.age as age,
d.n_lang as language,
l.score as laterality,
d.bike as bike,
d.car as drive,
d.accident as accident,
users.eGroup as group,
users.sct1 as sct1,
users.sct2 as sct2,
v.finding as findingFor,
v.p_responsibility as plaintiff_resp,
v.confidence as confidence,
users.comprehension as comprehension,
users.reasoning as reasoning,
users.exclude as exclude,
users.reason as reason,
users.created as start,
users.updated as end
FROM users 
LEFT OUTER JOIN decisions v ON v.userID = users.id 
LEFT OUTER JOIN laterality l ON users.id = l.userID  
LEFT OUTER JOIN demos d ON users.id = d.user_iD ;