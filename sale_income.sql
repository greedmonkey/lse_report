SELECT CPA.PAYMENT_DATE, 
	CPA.RECEIPT_NO, 
	C.CLIENT_NO, 
	CONCAT(C.PREFIX_NAME, C.FIRST_NAME_EN, ' ', C.LAST_NAME_EN ) AS CLIENT_NAME,
	GN.`NAME` AS GROUP_NAME, 
	COT.NAME_EN AS COURSE_TYPE, 
	CO.`NAME` AS COURSE_NAME, 
	GN.START_DATE AS PERIOD_FROM, 
	GN.END_DATE AS PERIOD_TO, 
	COL.NAME_EN AS COURSE_LEVEL, 
	CP.TOTAL_LESSON AS LESSON, 
	CP.COURSE_PRICE_TOTAL as COURSE_PRICE_TOTAL,
	CPAD.DISCOUNT_PRICE as EXTRA_DISCOUNT,
	CONCAT(ECPAD.PREFIX_NAME, ECPAD.FIRST_NAME_EN, ' ', ECPAD.LAST_NAME_EN ) AS EXTRA_DISCOUNT_BY_NAME, 
	/*S.`CODE` AS STOCK_CODE, */
	/*S.NAME_EN AS STOCK_NAME,*/
	GROUP_CONCAT(S.NAME_EN SEPARATOR ', ') as STOCK_NAME,
	SUM(CPS.STOCK_AMOUNT) as STOCK_AMONT,
	/*CPS.STOCK_AMOUNT, */
	SUM(CPS.STOCK_PRICE_TOTAL) as STOCK_PRICE_TOTAL,
	/*CPS.STOCK_PRICE_TOTAL, */
	CP.TOTAL_PRICE AS GRAND_TOTAL, 
	PT.NAME_EN AS TYPE_OF_PAYMENT, 
	CONCAT(E.PREFIX_NAME, E.FIRST_NAME_EN, ' ', E.LAST_NAME_EN ) AS CONSULT_NAME,
	GROUP_CONCAT(PRO.NAME_EN SEPARATOR ', ') as PROMOTION_NAME,
	/*PRO.NAME_EN AS PROMOTION_NAME, */
	CC.NAME_EN AS CONTACT_CHANNEL, 
	C.CONTACT_CHANNEL_DETAIL, 
	MS.NAME_EN AS MARKETING_SOURCE, 
	C.MARKETING_SOURCE_DETAIL
FROM CLIENT_PAYMENT_AMOUNT CPA 
INNER JOIN CLIENT C ON C.ID = CPA.CLIENT_ID
INNER JOIN EMPLOYEE E ON C.SALES_ID = E.ID
INNER JOIN CLIENT_PAYMENT CP ON CP.ID = CPA.CLIENT_PAYMENT_ID
INNER JOIN REF_PAYMENT_TYPE PT ON CPA.PAYMENT_TYPE_ID = PT.ID
LEFT JOIN GROUP_NAME GN ON CP.GROUP_ID = GN.ID
LEFT JOIN REF_COURSE_TYPE COT ON COT.ID = CP.COURSE_TYPE_ID
LEFT JOIN COURSE CO ON CO.ID = CP.COURSE_ID
LEFT JOIN CLIENT_PAYMENT_STOCK CPS ON CPS.CLIENT_PAYMENT_ID = CP.ID
LEFT JOIN CLIENT_PAYMENT_PROMOTION CPP ON CPP.CLIENT_PAYMENT_ID = CP.ID
LEFT JOIN PROMOTION PRO ON CPP.PROMOTION_ID = PRO.ID
LEFT JOIN STOCK S ON CPS.STOCK_ID = S.ID
LEFT JOIN REF_COURSE_LEVEL COL ON CO.COURSE_LEVEL_ID = COL.ID
LEFT JOIN CLIENT_PAYMENT_ADDITION CPAD ON CP.ID = CPAD.CLIENT_PAYMENT_ID AND CPAD.ACTIVE = 1 AND CPAD.PAYMENT_ADDITION_TYPE_ID = 9999
LEFT JOIN EMPLOYEE ECPAD ON CPAD.MODIFY_BY = ECPAD.ID
LEFT JOIN REF_CONTACT_CHANNEL CC ON C.CONTACT_CHANNEL_ID = CC.ID
LEFT JOIN REF_MARKETING_SOURCE MS ON C.MARKETING_SOURCE_ID = MS.ID
GROUP BY CPA.ID