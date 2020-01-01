/*--A.1 Get group totals*/ 
/* -- look for comparable totals for each level of the factor */ 
FREQUENCIES VARIABLES=iv_group_n 
  /ORDER=ANALYSIS.


/*--A.2 Get DV correlations*/
CORRELATIONS 
  /VARIABLES=dv_confidence_n dv_comprehension_n dv_reasoning_n dv_plaintiff_responsibility_n dv_time_n r_reason_time r_comp_time 
  /PRINT=TWOTAIL NOSIG 
  /MISSING=PAIRWISE.


/*--F.3 Factorial MANOVA reasoning/comprehension 
GLM dv_comprehension_n dv_reasoning_n  BY iv_axis_n iv_direction_n 
  /METHOD=SSTYPE(3) 
  /INTERCEPT=INCLUDE 
  /PLOT=PROFILE(iv_axis_n*iv_direction_n iv_direction_n*iv_axis_n) 
  /PRINT=DESCRIPTIVE ETASQ HOMOGENEITY 
  /CRITERIA=ALPHA(.05) 
  /DESIGN= iv_axis_n iv_direction_n iv_axis_n*iv_direction_n.


/*--D.6 PLAINTIFF RESP FACTORIAL ANOVA*/ 
UNIANOVA dv_plaintiff_responsibility_n BY iv_axis_n iv_direction_n 
  /METHOD=SSTYPE(3) 
  /INTERCEPT=INCLUDE 
  /PLOT=PROFILE(iv_axis_n*iv_direction_n iv_direction_n*iv_axis_n) 
  /EMMEANS=TABLES(iv_axis_n) COMPARE ADJ(BONFERRONI) 
  /EMMEANS=TABLES(iv_direction_n) COMPARE ADJ(BONFERRONI) 
  /EMMEANS=TABLES(iv_axis_n*iv_direction_n) 
  /PRINT=HOMOGENEITY DESCRIPTIVE 
  /CRITERIA=ALPHA(.05) 
  /DESIGN=iv_axis_n iv_direction_n iv_axis_n*iv_direction_n.

/*--D.5 CONFIDENCE FACTORIAL ANOVA*/ 
UNIANOVA dv_confidence_n BY iv_axis_n iv_direction_n 
  /METHOD=SSTYPE(3) 
  /INTERCEPT=INCLUDE 
  /PLOT=PROFILE(iv_axis_n*iv_direction_n iv_direction_n*iv_axis_n) 
  /EMMEANS=TABLES(iv_axis_n) COMPARE ADJ(BONFERRONI) 
  /EMMEANS=TABLES(iv_direction_n) COMPARE ADJ(BONFERRONI) 
  /EMMEANS=TABLES(iv_axis_n*iv_direction_n) 
  /PRINT=HOMOGENEITY DESCRIPTIVE 
  /CRITERIA=ALPHA(.05) 
  /DESIGN=iv_axis_n iv_direction_n iv_axis_n*iv_direction_n.

/*--D.3 RUNTIME FACTORIAL ANOVA*/ 
UNIANOVA dv_time_n BY iv_axis_n iv_direction_n 
  /METHOD=SSTYPE(3) 
  /INTERCEPT=INCLUDE 
  /PLOT=PROFILE(iv_axis_n*iv_direction_n iv_direction_n*iv_axis_n) 
  /EMMEANS=TABLES(iv_axis_n) COMPARE ADJ(BONFERRONI) 
  /EMMEANS=TABLES(iv_direction_n) COMPARE ADJ(BONFERRONI) 
  /EMMEANS=TABLES(iv_axis_n*iv_direction_n) 
  /PRINT=HOMOGENEITY DESCRIPTIVE 
  /CRITERIA=ALPHA(.05) 
  /DESIGN=iv_axis_n iv_direction_n iv_axis_n*iv_direction_n.
