/*RECODE AND SETUP VARIABLES */ 

/*RECODE GROUP*/
recode r_group (1=1) (2=2) (3=3) (4=4) into iv_group_n.
execute.

VALUE LABELS
iv_group_n
1 'LR'
2 'TB'
3 'RL'
4 'BT'.
execute.

/*RECODE GROUP*/
recode r_group (1=1) (2=2) (3=2) (4=3) into iv_group3_n.
execute.

VALUE LABELS
iv_group3_n
1 'consistent'
2 'inconsistent'
3 'contradictory'.
execute.

/*RECODE GENDER */
recode r_gender ('m'=1) ('f'=2) into x_gender_n.
execute.

VALUE LABELS
x_gender_n
1 'MALE'
2 'FEMALE'.
execute.

/*RECODE LANGUAGE */

do if (r_language = "english").
compute c_language_n = 1.
else. 
compute c_language_n = 0.
end if.
execute.

VALUE LABELS
c_language_n
1 'ENGLISH'
0 'OTHER'.
execute.

/*CREATE FACTOR 1: AXIS */
recode iv_group_n (1=1) (3=1) (2=2) (4=2) into iv_axis_n.
execute.

VALUE LABELS
iv_axis_n
1 'HORIZONTAL'
2 'VERTICAL'.
execute.

/*CREATE FACTOR 2: DIRECTION */
recode iv_group_n (1=1) (3=2) (2=1) (4=2) into iv_direction_n.
execute.

VALUE LABELS
iv_direction_n
1 'CONSISTENT'
2 'INCONSISTENT'.
execute.

/*RECODE SCT1 AS NUMERIC */
recode r_sct1 ('lr'=1) ('tb'=2) ('rl'=3) ('bt'=4) into dv_sct1_n.
execute.

/*RECODE SCT2AS NUMERIC */
recode r_sct2 ('lr'=1) ('tb'=2) ('rl'=3) ('bt'=4) into dv_sct2_n.
execute.

/*EVALUATE SCT1 AS BINARY (LR = 1.0, ALL OTHERS = 0*/
recode dv_sct1_n (1=1) (2=0) (3=0) (4=0) into c_sct.
execute.

VALUE LABELS
dv_sct1_n
1 'LR'
2 'TB'
3 'RL'
4 'BT'.
execute.

VALUE LABELS
c_sct
1 'LR'
2 'TB'
3 'RL'
4 'BT'.
execute.

VALUE LABELS
dv_sct2_n
1 'LR'
2 'TB'
3 'RL'
4 'BT'.
execute.

/*EVALUATE CHOICE BEHAVIOR BASED ON i_group,SCT1,SCT2 */
/* note: must create choice_beh as string variable first*/

do if ( iv_group_n = 1) and (dv_sct1_n = 1) and (dv_sct2_n = 1).
compute dv_choice_beh_s = "indeterminate". 
else if ( iv_group_n = 2) and (dv_sct1_n = 2) and (dv_sct2_n = 2). 
compute dv_choice_beh_s = "indeterminate".
else if ( iv_group_n = 3) and (dv_sct1_n = 3) and (dv_sct2_n = 3). 
compute dv_choice_beh_s = "indeterminate".
else if ( iv_group_n = 4) and (dv_sct1_n = 4) and (dv_sct2_n = 4). 
compute dv_choice_beh_s = "indeterminate".
else if ( iv_group_n = 1) and (dv_sct1_n <> 1) and (dv_sct2_n = 1). 
compute dv_choice_beh_s = "adapt".
else if ( iv_group_n= 2) and (dv_sct1_n <> 2) and (dv_sct2_n = 2). 
compute dv_choice_beh_s = "adapt".
else if ( iv_group_n = 3) and (dv_sct1_n <> 3) and (dv_sct2_n = 3). 
compute dv_choice_beh_s = "adapt".
else if ( iv_group_n = 4) and (dv_sct1_n <>4) and (dv_sct2_n = 4). 
compute dv_choice_beh_s = "adapt".
else if ( iv_group_n<> 1) and (dv_sct1_n = 1) and (dv_sct2_n = 1). 
compute dv_choice_beh_s = "persist".
else if ( iv_group_n <> 2) and (dv_sct1_n = 2) and (dv_sct2_n = 2). 
compute dv_choice_beh_s = "persist".
else if ( iv_group_n <> 3) and (dv_sct1_n = 3) and (dv_sct2_n = 3). 
compute dv_choice_beh_s = "persist".
else if ( iv_group_n <> 4) and (dv_sct1_n = 4) and (dv_sct2_n = 4). 
compute dv_choice_beh_s = "persist".
else.
compute dv_choice_beh_s = "neither".
end if.
execute.

/*RECODE CHOICE BEHAVIOR AS NUMERIC*/

recode dv_choice_beh_s ("persist"=1 ) ("adapt"=2) ("neither"=3) ("indeterminate"=4) into dv_choice_beh_n.
execute.

VALUE LABELS
dv_choice_beh_n
1 'PERSIST'
2 'ADAPT'
3 'NEITHER'
4 'INDETERMINATE'.
execute.

/*EVALUATE VERDICT AS NUMERIC*/
recode r_finding_for ("P" = 1) ("D" = 2) into dv_verdict_n.
execute.

VALUE LABELS
dv_verdict_n
1 'FOR PLAINTIFF'
2 'FOR DEFENDANT'.
execute.


/*TRANSFER CONTINUOUS DVS*/

compute dv_plaintiff_responsibility_n = r_plaintiff_responsibility.
compute dv_confidence_n = r_confidence.
compute dv_comprehension_n = r_comprehension.
compute dv_reasoning_n = r_reasoning.
compute dv_time_n = r_time.
execute.




