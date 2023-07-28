
-- GET GROUP TOTALS
SELECT  
    COUNT(*) AS 'TOTAL RUN', 
    COUNT(IF(eGroup='1',1,null)) as G1,
    COUNT(IF(eGroup='2',1,null)) as G2,
    COUNT(IF(eGroup='3',1,null)) as G3,
    COUNT(IF(eGroup='4',1,null)) as G4
FROM users
WHERE (session in ('chair'));

-- GET SCT1 TOTALS
SELECT 
	COUNT(*) AS 'TOTAL RUN',
    COUNT(IF(sct1 = 'lr',1,null)) as LR,
    COUNT(IF(sct1 = 'tb',1,null)) as TB,
    COUNT(IF(sct1 = 'rl',1,null)) as RL,
    COUNT(IF(sct1 = 'bt',1,null)) as BT,
    COUNT(IF(sct1 is null,1,null)) as 'NULL'
FROM users
WHERE (session in ('chair'));


-- GET ELLIGIBLE GROUP TOTALS
SELECT 
	COUNT(*) AS 'TOTAL RUN',
	COUNT(IF(sct1 = 'lr',1,null)) as 'SCT1 Elligible', 
    COUNT(IF(eGroup='1' && sct1 = 'lr',1,null)) as G1,
    COUNT(IF(eGroup='2' && sct1 = 'lr',1,null)) as G2,
    COUNT(IF(eGroup='3' && sct1 = 'lr',1,null)) as G3,
    COUNT(IF(eGroup='4' && sct1 = 'lr',1,null)) as G4
FROM users
WHERE (session in ('chair'));
	


