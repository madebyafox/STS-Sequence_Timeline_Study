/*--A.1 Get group totals*/ 
/* -- look for comparable totals for each level of the factor */ 
FREQUENCIES VARIABLES=dv_sct2_n 
  /ORDER=ANALYSIS.

/*--A.2 Get DV correlations*/
CORRELATIONS 
  /VARIABLES=dv_confidence_n dv_comprehension_n dv_reasoning_n dv_plaintiff_responsibility_n dv_time_n r_reason_time r_comp_time 
  /PRINT=TWOTAIL NOSIG 
  /MISSING=PAIRWISE.

/*--F.3  MANOVA reasoning/comprehension for 
GLM dv_comprehension_n dv_reasoning_n BY dv_sct2_n 
  /METHOD=SSTYPE(3) 
  /INTERCEPT=INCLUDE 
  /POSTHOC=dv_sct2_n(TUKEY) 
  /PLOT=PROFILE(dv_sct2_n) 
  /EMMEANS=TABLES(dv_sct2_n) COMPARE ADJ(BONFERRONI) 
  /PRINT=DESCRIPTIVE ETASQ HOMOGENEITY 
  /CRITERIA=ALPHA(.05) 
  /DESIGN= dv_sct2_n.

/*--D.6 PLAINTIFF RESP  ANOVA*/ 
UNIANOVA dv_plaintiff_responsibility_n BY dv_sct2_n
  /METHOD=SSTYPE(3) 
  /INTERCEPT=INCLUDE 
  /POSTHOC=dv_sct2_n(TUKEY) 
  /PLOT=PROFILE(dv_sct2_n) 
  /EMMEANS=TABLES(dv_sct2_n) 
  /PRINT=ETASQ HOMOGENEITY DESCRIPTIVE 
  /CRITERIA=ALPHA(.05) 
  /DESIGN=dv_sct2_n.

/*--D.5 CONFIDENCE  ANOVA*/ 
UNIANOVA dv_confidence_n BY dv_sct2_n
  /METHOD=SSTYPE(3) 
  /INTERCEPT=INCLUDE 
  /POSTHOC=dv_sct2_n(TUKEY) 
  /PLOT=PROFILE(dv_sct2_n) 
  /EMMEANS=TABLES(dv_sct2_n) 
  /PRINT=ETASQ HOMOGENEITY DESCRIPTIVE 
  /CRITERIA=ALPHA(.05) 
  /DESIGN=dv_sct2_n.

/*--D.3 RUNTIME  ANOVA*/ 
UNIANOVA dv_time_n BY dv_sct2_n
  /METHOD=SSTYPE(3) 
  /INTERCEPT=INCLUDE 
  /POSTHOC=dv_sct2_n(TUKEY) 
  /PLOT=PROFILE(dv_sct2_n) 
  /EMMEANS=TABLES(dv_sct2_n) 
  /PRINT=ETASQ HOMOGENEITY DESCRIPTIVE 
  /CRITERIA=ALPHA(.05) 
  /DESIGN=dv_sct2_n.

/*--D.4 REASONING TIME  ANOVA*/ 
UNIANOVA r_reason_time BY dv_sct2_n
  /METHOD=SSTYPE(3) 
  /INTERCEPT=INCLUDE 
  /POSTHOC=dv_sct2_n(TUKEY) 
  /PLOT=PROFILE(dv_sct2_n) 
  /EMMEANS=TABLES(dv_sct2_n) 
  /PRINT=ETASQ HOMOGENEITY DESCRIPTIVE 
  /CRITERIA=ALPHA(.05) 
  /DESIGN=dv_sct2_n.
