-- GET ELLIGIBLE GROUP TOTALS
SELECT 
	COUNT(*) AS 'TOTAL RUN',
	COUNT(IF(session ='icv',1,null)) as ICV,
	COUNT(IF(sct1 = 'lr',1,null)) as 'SCT1 Elligible', 
    COUNT(IF(eGroup='1' && sct1 = 'lr',1,null)) as G1,
    COUNT(IF(eGroup='2' && sct1 = 'lr',1,null)) as G2,
    COUNT(IF(eGroup='3' && sct1 = 'lr',1,null)) as G3,
    COUNT(IF(eGroup='4' && sct1 = 'lr',1,null)) as G4
FROM users
WHERE (session in ('pilot','icv','chair','dance','echo','fashion','game','habit','instant','jello','kite','lamp','march','noun','onion','question','pear','ranger')
and complete = 1);


-- MASTER USER FILE
SELECT 
users.id as id,
users.session as sess,
users.exclude as exclude,
users.reason as reason,
d.n_lang as language,
users.eGroup as eGroup,
users.sct1 as sct1,
users.sct2 as sct2,
d.gender as gender,
l.score as laterality,
d.bike as bike,
d.car as drive,
d.accident as accident,
d.age as age,
v.finding as verdict,
v.p_responsibility as pResp,
v.confidence as conf,
users.comprehension as comp,
users.created as start,
users.updated as end
FROM users 
LEFT OUTER JOIN decisions v ON v.userID = users.id 
LEFT OUTER JOIN laterality l ON users.id = l.userID  
LEFT OUTER JOIN demos d ON users.id = d.user_iD 
where 
users.sct1 is not null and 
users.sct2 is not null and 
users.complete = 1;	 