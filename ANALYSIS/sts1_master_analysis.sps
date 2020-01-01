/*SECTION A: SAMPLE ANALYSIS*/

/*--A.1 Get group totals*/
/* -- look for comparable totals for each level of the factor */
FREQUENCIES VARIABLES=iv_group_n 
  /ORDER=ANALYSIS.

/*--A.2 Descriptives on DVs*/
DESCRIPTIVES VARIABLES=dv_comprehension_n dv_reasoning_n dv_plaintiff_responsibility_n dv_confidence_n dv_time_n 
  /STATISTICS=MEAN STDDEV MIN MAX KURTOSIS SKEWNESS.

/*--A.3 Descriptives on DVs*/
EXAMINE VARIABLES=dv_comprehension_n dv_reasoning_n dv_plaintiff_responsibility_n dv_confidence_n dv_time_n BY iv_group_n 
  /PLOT NONE 
  /STATISTICS DESCRIPTIVES 
  /CINTERVAL 95 
  /MISSING LISTWISE 
  /NOTOTAL.

/*--A.4 Descripitves with boxplot on comprehension and reasoning*/
EXAMINE VARIABLES=dv_comprehension_n dv_reasoning_n BY iv_group_n 
  /PLOT BOXPLOT 
  /COMPARE VARIABLES 
  /STATISTICS NONE 
  /CINTERVAL 95 
  /MISSING LISTWISE 
  /NOTOTAL.

/*--A.5 Descripitves with boxplot on plaintiff responsibility and confidence*/
EXAMINE VARIABLES=dv_plaintiff_responsibility_n dv_confidence_n BY iv_group_n 
  /PLOT BOXPLOT 
  /COMPARE VARIABLES 
  /STATISTICS NONE 
  /CINTERVAL 95 
  /MISSING LISTWISE 
  /NOTOTAL.

/*SECTION B: DEPENDENT MEASURES ANALYSIS*/

/*--B.1 COMPREHENSION NORMALITY */
/*If the Sig. value of the Shapiro-Wilk Test > 0.05, the data is normal 
/*ELSE the data significantly deviate from a normal distribution
EXAMINE VARIABLES=dv_comprehension_n 
  /PLOT HISTOGRAM NPPLOT 
  /COMPARE GROUPS 
  /STATISTICS DESCRIPTIVES EXTREME 
  /CINTERVAL 95 
  /MISSING LISTWISE 
  /NOTOTAL.

/*--B.2 REASONING NORMALITY*/
EXAMINE VARIABLES=dv_reasoning_n 
  /PLOT HISTOGRAM NPPLOT 
  /COMPARE GROUPS 
  /STATISTICS DESCRIPTIVES EXTREME 
  /CINTERVAL 95 
  /MISSING LISTWISE 
  /NOTOTAL.

/*--B.3 RUNTIME NORMALITY */
EXAMINE VARIABLES=dv_time_n 
  /PLOT HISTOGRAM NPPLOT 
  /COMPARE GROUPS 
  /STATISTICS DESCRIPTIVES EXTREME 
  /CINTERVAL 95 
  /MISSING LISTWISE 
  /NOTOTAL.

/*--B.4 REASONING TIME NORMALITY */
EXAMINE VARIABLES=r_reason_time 
  /PLOT HISTOGRAM NPPLOT 
  /COMPARE GROUPS 
  /STATISTICS DESCRIPTIVES EXTREME 
  /CINTERVAL 95 
  /MISSING LISTWISE 
  /NOTOTAL.

/*--B.5 CONFIDENCE NORMALITY  */
EXAMINE VARIABLES=dv_confidence_n
  /PLOT HISTOGRAM NPPLOT 
  /COMPARE GROUPS 
  /STATISTICS DESCRIPTIVES EXTREME 
  /CINTERVAL 95 
  /MISSING LISTWISE 
  /NOTOTAL.

/*--B.6 PLAINTIFF RESPONSIBILITY NORMALITY */
EXAMINE VARIABLES=dv_plaintiff_responsibility_n
  /PLOT HISTOGRAM NPPLOT 
  /COMPARE GROUPS 
  /STATISTICS DESCRIPTIVES EXTREME 
  /CINTERVAL 95 
  /MISSING LISTWISE 
  /NOTOTAL.

/*SECTION C: SIMPLE  BETWEEN GROUP ANALYSIS*/

/*--C.1 COMPREHENSION ANOVA  */
/*test apriori hypothesis that LR much > TB little bit > BT much > RL
ONEWAY dv_comprehension_n BY iv_group_n 
  /CONTRAST=3 1 -4 0 
  /STATISTICS DESCRIPTIVES HOMOGENEITY 
  /PLOT MEANS 
  /MISSING ANALYSIS 
  /POSTHOC=TUKEY ALPHA(0.05).

/*--C.2.1 REASONING ANOVA*/
/*test apriori hypothesis that LR much > TB little bit > BT much > RL
ONEWAY dv_reasoning_n BY iv_group_n 
  /CONTRAST=3 1 -4 0 
  /STATISTICS DESCRIPTIVES HOMOGENEITY 
  /PLOT MEANS 
  /MISSING ANALYSIS 
  /POSTHOC=TUKEY ALPHA(0.05).

/*--C.2.2 REASONING NON-PARAMETRIC  */
NPAR TESTS 
  /K-W=dv_reasoning_n BY iv_group_n(1 4) 
  /STATISTICS DESCRIPTIVES 
  /MISSING ANALYSIS.

/*--C.3.1 RUNTIME ANOVA*/
/*test apriori hypothesis that LR much > TB little bit > BT much > RL
ONEWAY dv_time_n BY iv_group_n 
  /CONTRAST=3 1 -4 0 
  /STATISTICS DESCRIPTIVES HOMOGENEITY 
  /PLOT MEANS 
  /MISSING ANALYSIS 
  /POSTHOC=TUKEY ALPHA(0.05).

/*--C.3.2 RUNTIME NON-PARAMETRIC  */
NPAR TESTS 
  /K-W=dv_time_n BY iv_group_n(1 4) 
  /STATISTICS DESCRIPTIVES 
  /MISSING ANALYSIS.

/*--C.4.1 REASONING TIME ANOVA*/
/*test apriori hypothesis that LR much > TB little bit > BT much > RL
ONEWAY r_reason_time BY iv_group_n 
  /CONTRAST=3 1 -4 0 
  /STATISTICS DESCRIPTIVES HOMOGENEITY 
  /PLOT MEANS 
  /MISSING ANALYSIS 
  /POSTHOC=TUKEY ALPHA(0.05).

/*--C.4.2 REASONING TIME NON-PARAMETRIC  */
NPAR TESTS 
  /K-W=r_reason_time BY iv_group_n(1 4) 
  /STATISTICS DESCRIPTIVES 
  /MISSING ANALYSIS.

/*--C.5.1 CONFIDENCE TIME ANOVA*/
/*test apriori hypothesis that LR much > TB little bit > BT much > RL
ONEWAY dv_confidence_n BY iv_group_n 
  /CONTRAST=3 1 -4 0 
  /STATISTICS DESCRIPTIVES HOMOGENEITY 
  /PLOT MEANS 
  /MISSING ANALYSIS 
  /POSTHOC=TUKEY ALPHA(0.05).

/*--C.5.2 REASONING TIME NON-PARAMETRIC  */
NPAR TESTS 
  /K-W=dv_confidence_n BY iv_group_n(1 4) 
  /STATISTICS DESCRIPTIVES 
  /MISSING ANALYSIS.

/*--C.6.1 PLAINTIFF RESP  ANOVA*/
/*test apriori hypothesis that LR much > TB little bit > BT much > RL
ONEWAY dv_plaintiff_responsibility_n BY iv_group_n 
  /CONTRAST=3 1 -4 0 
  /STATISTICS DESCRIPTIVES HOMOGENEITY 
  /PLOT MEANS 
  /MISSING ANALYSIS 
  /POSTHOC=TUKEY ALPHA(0.05).

/*--C.6.2 REASONING TIME NON-PARAMETRIC  */
NPAR TESTS 
  /K-W=dv_plaintiff_responsibility_n BY iv_group_n(1 4) 
  /STATISTICS DESCRIPTIVES 
  /MISSING ANALYSIS.

/*SECTION D: FACTORIAL  BETWEEN GROUP ANALYSIS*/

/*--D.1 COMPREHENSION FACTORIAL ANOVA  */
UNIANOVA dv_comprehension_n BY iv_axis_n iv_direction_n 
  /METHOD=SSTYPE(3) 
  /INTERCEPT=INCLUDE 
  /PLOT=PROFILE(iv_axis_n*iv_direction_n iv_direction_n*iv_axis_n) 
  /EMMEANS=TABLES(iv_axis_n) COMPARE ADJ(BONFERRONI) 
  /EMMEANS=TABLES(iv_direction_n) COMPARE ADJ(BONFERRONI) 
  /EMMEANS=TABLES(iv_axis_n*iv_direction_n) 
  /PRINT=HOMOGENEITY DESCRIPTIVE 
  /CRITERIA=ALPHA(.05) 
  /DESIGN=iv_axis_n iv_direction_n iv_axis_n*iv_direction_n.

/*--D.2 REASONING FACTORIAL ANOVA  */
UNIANOVA dv_reasoning_n BY iv_axis_n iv_direction_n 
  /METHOD=SSTYPE(3) 
  /INTERCEPT=INCLUDE 
  /PLOT=PROFILE(iv_axis_n*iv_direction_n iv_direction_n*iv_axis_n) 
  /EMMEANS=TABLES(iv_axis_n) COMPARE ADJ(BONFERRONI) 
  /EMMEANS=TABLES(iv_direction_n) COMPARE ADJ(BONFERRONI) 
  /EMMEANS=TABLES(iv_axis_n*iv_direction_n) 
  /PRINT=HOMOGENEITY DESCRIPTIVE 
  /CRITERIA=ALPHA(.05) 
  /DESIGN=iv_axis_n iv_direction_n iv_axis_n*iv_direction_n.

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

/*SECTION E: CORRELATIONS OF DEPENDENT MEASURES*/
/*examine correlations between dependent variables in order to determine suitability for MANOVA
/* to use MANOVA, pairwise correlations should be moderately corelated (significant, but less than .90) in order to 
/* avoid multicolinearity 
CORRELATIONS 
  /VARIABLES=dv_comprehension_n dv_reasoning_n dv_time_n r_reason_time dv_plaintiff_responsibility_n dv_verdict_n dv_confidence_n     
  /PRINT=TWOTAIL NOSIG 
  /MISSING=PAIRWISE.

/*SECTION F: ANCOVAS & MANOVAS TESTS*/

/*--F.1 ANCOVA for reasoning w/ c = reasoning_time*/
UNIANOVA dv_reasoning_n BY iv_group_n WITH r_reason_time 
  /METHOD=SSTYPE(3) 
  /INTERCEPT=INCLUDE 
  /PLOT=PROFILE(iv_group_n) 
  /PRINT=HOMOGENEITY DESCRIPTIVE 
  /CRITERIA=ALPHA(.05) 
  /DESIGN=r_reason_time iv_group_n.

/*--F.2 ANCOVA for reasoning w/ c = comprehension */
UNIANOVA dv_reasoning_n BY iv_group_n WITH dv_comprehension_n 
  /METHOD=SSTYPE(3) 
  /INTERCEPT=INCLUDE 
  /PLOT=PROFILE(iv_group_n) 
  /PRINT=HOMOGENEITY DESCRIPTIVE 
  /CRITERIA=ALPHA(.05) 
  /DESIGN=dv_comprehension_n iv_group_n.

/*--F.3 Factorial MANOVA reasoning/comprehension
GLM dv_comprehension_n dv_reasoning_n  BY iv_axis_n iv_direction_n 
  /METHOD=SSTYPE(3) 
  /INTERCEPT=INCLUDE 
  /PLOT=PROFILE(iv_axis_n*iv_direction_n iv_direction_n*iv_axis_n) 
  /PRINT=DESCRIPTIVE ETASQ HOMOGENEITY 
  /CRITERIA=ALPHA(.05) 
  /DESIGN= iv_axis_n iv_direction_n iv_axis_n*iv_direction_n.

/*--F.4 Factorial MANOVA reasoning/reasoning_time
GLM dv_comprehension_n dv_reasoning_n dv_time_n BY iv_axis_n iv_direction_n 
  /METHOD=SSTYPE(3) 
  /INTERCEPT=INCLUDE 
  /PLOT=PROFILE(iv_axis_n*iv_direction_n iv_direction_n*iv_axis_n) 
  /PRINT=DESCRIPTIVE ETASQ HOMOGENEITY 
  /CRITERIA=ALPHA(.05) 
  /DESIGN= iv_axis_n iv_direction_n iv_axis_n*iv_direction_n.

/*--F.5 Factorial MANOVA reasoning/plaintiff_resp
GLM dv_comprehension_n dv_reasoning_n dv_time_n BY iv_axis_n iv_direction_n 
  /METHOD=SSTYPE(3) 
  /INTERCEPT=INCLUDE 
  /PLOT=PROFILE(iv_axis_n*iv_direction_n iv_direction_n*iv_axis_n) 
  /PRINT=DESCRIPTIVE ETASQ HOMOGENEITY 
  /CRITERIA=ALPHA(.05) 
  /DESIGN= iv_axis_n iv_direction_n iv_axis_n*iv_direction_n.

/*SECTION G: DVTS BY SCT1*/

/*--G.1 COMPREHENSION ANOVA  */
/*test apriori hypothesis that LR much > TB little bit > BT much > RL
ONEWAY dv_comprehension_n BY dv_sct1_n
 /CONTRAST=3 1 -4 0 
  /STATISTICS DESCRIPTIVES HOMOGENEITY 
  /PLOT MEANS 
  /MISSING ANALYSIS 
  /POSTHOC=TUKEY ALPHA(0.05).

/*--G.2 REASONING ANOVA*/
/*test apriori hypothesis that LR much > TB little bit > BT much > RL
ONEWAY dv_reasoning_n BY dv_sct1_n
  /CONTRAST=3 1 -4 0 
  /STATISTICS DESCRIPTIVES HOMOGENEITY 
  /PLOT MEANS 
  /MISSING ANALYSIS 
  /POSTHOC=TUKEY ALPHA(0.05).

/*--G.3.1 RUNTIME ANOVA*/
/*test apriori hypothesis that LR much > TB little bit > BT much > RL
ONEWAY dv_time_n BY dv_sct1_n 
  /CONTRAST=3 1 -4 0 
  /STATISTICS DESCRIPTIVES HOMOGENEITY 
  /PLOT MEANS 
  /MISSING ANALYSIS 
  /POSTHOC=TUKEY ALPHA(0.05).

/*--G.4.1 REASONING TIME ANOVA*/
/*test apriori hypothesis that LR much > TB little bit > BT much > RL
ONEWAY r_reason_time BY dv_sct1_n 
  /CONTRAST=3 1 -4 0 
  /STATISTICS DESCRIPTIVES HOMOGENEITY 
  /PLOT MEANS 
  /MISSING ANALYSIS 
  /POSTHOC=TUKEY ALPHA(0.05).

/*--G.5.1 CONFIDENCE TIME ANOVA*/
/*test apriori hypothesis that LR much > TB little bit > BT much > RL
ONEWAY dv_confidence_n BY dv_sct1_n 
  /CONTRAST=3 1 -4 0 
  /STATISTICS DESCRIPTIVES HOMOGENEITY 
  /PLOT MEANS 
  /MISSING ANALYSIS 
  /POSTHOC=TUKEY ALPHA(0.05).

/*--G.6.1 PLAINTIFF RESP  ANOVA*/
/*test apriori hypothesis that LR much > TB little bit > BT much > RL
ONEWAY dv_plaintiff_responsibility_n BY dv_sct1_n 
  /CONTRAST=3 1 -4 0 
  /STATISTICS DESCRIPTIVES HOMOGENEITY 
  /PLOT MEANS 
  /MISSING ANALYSIS 
  /POSTHOC=TUKEY ALPHA(0.05).

/*SECTION H: DVTS BY SCT2*/

/*--H.1 COMPREHENSION ANOVA  */
/*test apriori hypothesis that LR much > TB little bit > BT much > RL
ONEWAY dv_comprehension_n BY dv_sct2_n
 /CONTRAST=3 1 -4 0 
  /STATISTICS DESCRIPTIVES HOMOGENEITY 
  /PLOT MEANS 
  /MISSING ANALYSIS 
  /POSTHOC=TUKEY ALPHA(0.05).

/*--H.2 REASONING ANOVA*/
/*test apriori hypothesis that LR much > TB little bit > BT much > RL
ONEWAY dv_reasoning_n BY dv_sct2_n
  /CONTRAST=3 1 -4 0 
  /STATISTICS DESCRIPTIVES HOMOGENEITY 
  /PLOT MEANS 
  /MISSING ANALYSIS 
  /POSTHOC=TUKEY ALPHA(0.05).

/*--H.3.1 RUNTIME ANOVA*/
/*test apriori hypothesis that LR much > TB little bit > BT much > RL
ONEWAY dv_time_n BY dv_sct2_n 
  /CONTRAST=3 1 -4 0 
  /STATISTICS DESCRIPTIVES HOMOGENEITY 
  /PLOT MEANS 
  /MISSING ANALYSIS 
  /POSTHOC=TUKEY ALPHA(0.05).

/*--H.4.1 REASONING TIME ANOVA*/
/*test apriori hypothesis that LR much > TB little bit > BT much > RL
ONEWAY r_reason_time BY dv_sct2_n 
  /CONTRAST=3 1 -4 0 
  /STATISTICS DESCRIPTIVES HOMOGENEITY 
  /PLOT MEANS 
  /MISSING ANALYSIS 
  /POSTHOC=TUKEY ALPHA(0.05).

/*--H.5.1 CONFIDENCE TIME ANOVA*/
/*test apriori hypothesis that LR much > TB little bit > BT much > RL
ONEWAY dv_confidence_n BY dv_sct2_n 
  /CONTRAST=3 1 -4 0 
  /STATISTICS DESCRIPTIVES HOMOGENEITY 
  /PLOT MEANS 
  /MISSING ANALYSIS 
  /POSTHOC=TUKEY ALPHA(0.05).

/*--H.6.1 PLAINTIFF RESP  ANOVA*/
/*test apriori hypothesis that LR much > TB little bit > BT much > RL
ONEWAY dv_plaintiff_responsibility_n BY dv_sct2_n 
  /CONTRAST=3 1 -4 0 
  /STATISTICS DESCRIPTIVES HOMOGENEITY 
  /PLOT MEANS 
  /MISSING ANALYSIS 
  /POSTHOC=TUKEY ALPHA(0.05).

*SECTION I: DVTS BY CHOICE BEHAVIOR*/

/*--I.1 COMPREHENSION ANOVA  */
/*test apriori hypothesis that LR much > TB little bit > BT much > RL
ONEWAY dv_comprehension_n BY dv_choice_beh_n
 /CONTRAST=3 1 -4 0 
  /STATISTICS DESCRIPTIVES HOMOGENEITY 
  /PLOT MEANS 
  /MISSING ANALYSIS 
  /POSTHOC=TUKEY ALPHA(0.05).

/*--I.2 REASONING ANOVA*/
/*test apriori hypothesis that LR much > TB little bit > BT much > RL
ONEWAY dv_reasoning_n BY dv_choice_beh_n
  /CONTRAST=3 1 -4 0 
  /STATISTICS DESCRIPTIVES HOMOGENEITY 
  /PLOT MEANS 
  /MISSING ANALYSIS 
  /POSTHOC=TUKEY ALPHA(0.05).

/*--I.3.1 RUNTIME ANOVA*/
/*test apriori hypothesis that LR much > TB little bit > BT much > RL
ONEWAY dv_time_n BY dv_choice_beh_n
  /CONTRAST=3 1 -4 0 
  /STATISTICS DESCRIPTIVES HOMOGENEITY 
  /PLOT MEANS 
  /MISSING ANALYSIS 
  /POSTHOC=TUKEY ALPHA(0.05).

/*--I.4.1 REASONING TIME ANOVA*/
/*test apriori hypothesis that LR much > TB little bit > BT much > RL
ONEWAY r_reason_time BY dv_choice_beh_n
  /CONTRAST=3 1 -4 0 
  /STATISTICS DESCRIPTIVES HOMOGENEITY 
  /PLOT MEANS 
  /MISSING ANALYSIS 
  /POSTHOC=TUKEY ALPHA(0.05).

/*--I.5.1 CONFIDENCE TIME ANOVA*/
/*test apriori hypothesis that LR much > TB little bit > BT much > RL
ONEWAY dv_confidence_n BY dv_choice_beh_n
  /CONTRAST=3 1 -4 0 
  /STATISTICS DESCRIPTIVES HOMOGENEITY 
  /PLOT MEANS 
  /MISSING ANALYSIS 
  /POSTHOC=TUKEY ALPHA(0.05).

/*--I.6.1 PLAINTIFF RESP  ANOVA*/
/*test apriori hypothesis that LR much > TB little bit > BT much > RL
ONEWAY dv_plaintiff_responsibility_n BY dv_choice_beh_n
  /CONTRAST=3 1 -4 0 
  /STATISTICS DESCRIPTIVES HOMOGENEITY 
  /PLOT MEANS 
  /MISSING ANALYSIS 
  /POSTHOC=TUKEY ALPHA(0.05).

