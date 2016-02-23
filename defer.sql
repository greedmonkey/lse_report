SELECT DISTINCT
Count(cpa.RECEIPT_NO) AS `Refs No.`,
gn.`NAME` AS `Group Name`,
rct.NAME_EN AS `Course Type`,
cos.`NAME` AS `Course Name`,
CONCAT(cli.PREFIX_NAME,cli.FIRST_NAME_EN,' ',cli.LAST_NAME_EN) AS `Student Name`,
cpa.PAYMENT_DATE AS Date,
cpa.RECEIPT_NO AS `Ref No.`,
cpa.PAYMENT_PRICE AS Amount,
gn.LESSON_TOTAL AS `Total Lesson`,
(cpa.PAYMENT_PRICE/gn.LESSON_TOTAL) AS `Bath/Lesson`,
gn.ID AS Group_ID
FROM
client_payment_amount AS cpa
LEFT JOIN client AS cli ON cpa.CLIENT_ID = cli.ID
LEFT JOIN group_register AS gr ON gr.CLIENT_ID = cli.ID
LEFT JOIN group_name AS gn ON gr.GROUP_ID = gn.ID
LEFT JOIN course AS cos ON gr.COURSE_ID = cos.ID
INNER JOIN ref_course_type AS rct ON gr.COURSE_TYPE_ID = rct.ID
LEFT JOIN classroom_book AS cosbook ON cosbook.GROUP_ID = gn.ID
GROUP BY
cpa.RECEIPT_NO
ORDER BY
cpa.RECEIPT_NO ASC




SELECT
client_payment_amount.RECEIPT_NO,
Count(classroom_book.ID) AS CLASS_PER_MONTH,
classroom_book.GROUP_ID,
YEAR(classroom_book.DATE),
MONTH(classroom_book.DATE)
FROM
client_payment_amount
LEFT JOIN client ON client_payment_amount.CLIENT_ID = client.ID
LEFT JOIN group_register ON group_register.CLIENT_ID = client.ID
LEFT JOIN classroom_book ON classroom_book.GROUP_ID = group_register.GROUP_ID
GROUP BY
classroom_book.GROUP_ID,
YEAR(classroom_book.DATE),
MONTH(classroom_book.DATE)
ORDER BY
client_payment_amount.RECEIPT_NO,
classroom_book.DATE