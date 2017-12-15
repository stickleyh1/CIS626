USE `Test626`;

INSERT INTO `customers` (`CustomerID`, `Username`, `Email`, `Password`, `Admin`) VALUES
(1, 'TestUser', 'test@test.com', '40371c25cf49e62e024f3f9dcfe0c6258efc00520fcd4751e4d4c8f378b8d27e', 0),
(2, 'stickleyh1', 'stickleyh1@student.lasalle.edu', '266a62e2abb64d125972f904dbf0e0086bdb3c819ee203c7ec55d52250d66695', 0),
(3, 'stickleyAdmin', 'admin@test.com', '266a62e2abb64d125972f904dbf0e0086bdb3c819ee203c7ec55d52250d66695', 1),
(4, 'AdminUser', 'admin1@test.com', '795b3195cc6d28361e1b70414647de950bc8f7469e8615119458476d7388cfff', 1),
(5, 'tester1', 'test1@test.com', 'b8376886c863590c33430664b617b72d89a326176ecf8fa20b1bfb5990ba0021', 0),
(6, 'crossen', 'crossen@lasalle.edu', '0d7b083019f7fea42dc9f33a85d4d7795aec46dba7a1bdfa23760e14ad824645', 0),
(7, 'crossenAdmin', 'admin2@test.com', '0fec7acf2d2104b0c1484e1f86b1ca2eb0dd80d9fd4cd0338af3274add2778ed', 1),
(8, 'tester2', 'tester2@test.com', '2b5bd022b8cf89a45492272ec4a6c4bb4e38db250df1c4a545e988e2cc96f577', 0);