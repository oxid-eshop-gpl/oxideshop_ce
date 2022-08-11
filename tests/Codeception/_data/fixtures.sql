SET @@session.sql_mode = '';
# for frontendMultidimensionalVariantsOnDetailsPage
#Articles demodata
REPLACE INTO `oxarticles` (`OXID`,   `OXSHOPID`,   `OXPARENTID`, `OXACTIVE`, `OXARTNUM`, `OXTITLE`,                     `OXSHORTDESC`,                   `OXPRICE`, `OXPRICEA`, `OXPRICEB`, `OXPRICEC`, `OXTPRICE`, `OXUNITNAME`, `OXUNITQUANTITY`, `OXVAT`, `OXWEIGHT`, `OXSTOCK`, `OXSTOCKFLAG`, `OXSTOCKTEXT`, `OXNOSTOCKTEXT`,       `OXDELIVERY`, `OXINSERT`,   `OXTIMESTAMP`,        `OXLENGTH`, `OXWIDTH`, `OXHEIGHT`, `OXSEARCHKEYS`, `OXISSEARCH`, `OXVARNAME`,              `OXVARSTOCK`, `OXVARCOUNT`, `OXVARSELECT`, `OXVARMINPRICE`, `OXVARMAXPRICE`, `OXVARNAME_1`,             `OXVARSELECT_1`,   `OXTITLE_1`,                 `OXSHORTDESC_1`,                        `OXSEARCHKEYS_1`, `OXBUNDLEID`, `OXSTOCKTEXT_1`,       `OXNOSTOCKTEXT_1`,         `OXSORT`, `OXVENDORID`,      `OXMANUFACTURERID`, `OXMINDELTIME`, `OXMAXDELTIME`, `OXDELTIMEUNIT`) VALUES
('10014',  1, '',            1,         '10014',    '13 DE product šÄßüл',         '14 DE description',              1.6,       0,          0,          0,          0,         '',            0,                NULL,    0,          0,         1,            '',              '',                  '0000-00-00', '2008-04-03', '2008-04-03 12:50:20', 0,          0,         0,         '',              1,           'size[DE] | color | type', 0,            12,          '',             15,               25,                   'size[EN] | color | type', '',                '14 EN product šÄßüл',       '13 EN description šÄßüл',              '',               '',           '',                    '',                         0,       '',                '',                  0,              0,             '');

#demodata for multidimensional variants
REPLACE INTO `oxarticles` (`OXID`,    `OXSHOPID`,   `OXPARENTID`, `OXACTIVE`, `OXARTNUM`, `OXPRICE`, `OXSTOCK`, `OXSTOCKFLAG`, `OXINSERT`,   `OXTIMESTAMP`,         `OXVARSELECT`,               `OXVARSELECT_1`,        `OXSUBCLASS`, `OXSORT`) VALUES
('1001432', 1, '10014',       1,         '10014-3-2', 15,        3,         1,            '2008-04-03', '2008-04-03 12:50:20', 'M | black | material [DE]', 'L | black | material', 'oxarticle',   3002),
('1001424', 1, '10014',       1,         '10014-2-4', 15,        0,         1,            '2008-04-03', '2008-04-03 12:50:20', 'M | red [DE]',              'M | red',              'oxarticle',   2004),
('1001422', 1, '10014',       1,         '10014-2-2', 15,        0,         3,            '2008-04-03', '2008-04-03 12:50:20', 'M | black | material [DE]', 'M | black | material', 'oxarticle',   2002),
('1001421', 1, '10014',       1,         '10014-2-1', 25,        0,         2,            '2008-04-03', '2008-04-03 12:50:20', 'M | black | lether [DE]',   'M | black | lether',   'oxarticle',   2001),
('1001411', 1, '10014',       1,         '10014-1-1', 25,        3,         1,            '2008-04-03', '2008-04-03 12:50:20', 'S | black | lether [DE]',   'S | black | lether',   'oxarticle',   1001),
('1001413', 1, '10014',       1,         '10014-1-3', 15,        3,         1,            '2008-04-03', '2008-04-03 12:50:20', 'S | white [DE]',            'S | white',            'oxarticle',   1003),
('1001412', 1, '10014',       1,         '10014-1-2', 15,        3,         1,            '2008-04-03', '2008-04-03 12:50:20', 'S | black | material [DE]', 'S | black | material', 'oxarticle',   1002),
('1001434', 1, '10014',       0,         '10014-3-4', 15,        3,         1,            '2008-04-03', '2008-04-03 12:50:20', 'L | red [DE]',              'L | red',              'oxarticle',   3004),
('1001423', 1, '10014',       1,         '10014-2-3', 15,        0,         1,            '2008-04-03', '2008-04-03 12:50:20', 'M | white [DE]',            'M | white',            'oxarticle',   2003),
('1001414', 1, '10014',       1,         '10014-1-4', 15,        3,         1,            '2008-04-03', '2008-04-03 12:50:20', 'S | red [DE]',              'S | red',              'oxarticle',   1004),
('1001431', 1, '10014',       1,         '10014-3-1', 15,        3,         1,            '2008-04-03', '2008-04-03 12:50:20', 'L | black | lether [DE]',   'L | black | lether',   'oxarticle',   3001),
('1001433', 1, '10014',       1,         '10014-3-3', 15,        3,         1,            '2008-04-03', '2008-04-03 12:50:20', 'L | white [DE]',            'L | white',            'oxarticle',   3003);


#Articles long desc
REPLACE INTO `oxartextends` (`OXID`,   `OXLONGDESC`, `OXLONGDESC_1`) VALUES
('10014',  '',                                            '');

# for frontendMultidimensionalVariantsOnDetailsPage, createBasketUserAccountWithoutRegistration
#Articles demodata
REPLACE INTO `oxarticles` (`OXID`,   `OXSHOPID`,   `OXPARENTID`, `OXACTIVE`, `OXARTNUM`, `OXTITLE`,                     `OXSHORTDESC`,                   `OXPRICE`, `OXPRICEA`, `OXPRICEB`, `OXPRICEC`, `OXTPRICE`, `OXUNITNAME`, `OXUNITQUANTITY`, `OXVAT`, `OXWEIGHT`, `OXSTOCK`, `OXSTOCKFLAG`, `OXSTOCKTEXT`, `OXNOSTOCKTEXT`,       `OXDELIVERY`, `OXINSERT`,   `OXTIMESTAMP`,        `OXLENGTH`, `OXWIDTH`, `OXHEIGHT`, `OXSEARCHKEYS`, `OXISSEARCH`, `OXVARNAME`,              `OXVARSTOCK`, `OXVARCOUNT`, `OXVARSELECT`, `OXVARMINPRICE`, `OXVARMAXPRICE`, `OXVARNAME_1`,             `OXVARSELECT_1`,   `OXTITLE_1`,                 `OXSHORTDESC_1`,                        `OXSEARCHKEYS_1`, `OXBUNDLEID`, `OXSTOCKTEXT_1`,       `OXNOSTOCKTEXT_1`,         `OXSORT`, `OXVENDORID`,      `OXMANUFACTURERID`, `OXMINDELTIME`, `OXMAXDELTIME`, `OXDELTIMEUNIT`) VALUES
                         ('1000',   1, '',            1,         '1000',     '[DE 4] Test product 0 šÄßüл', 'Test product 0 short desc [DE]', 50,        35,         45,         55,         0,         'kg',          2,                NULL,    2,          15,        1,            'In stock [DE]', 'Out of stock [DE]', '0000-00-00', '2008-02-04', '2008-02-04 17:07:48', 1,          2,         2,         'search1000',    1,           '',                        0,            0,           '',             50,                0,                   '',                        '',                'Test product 0 [EN] šÄßüл', 'Test product 0 short desc [EN] šÄßüл', 'šÄßüл1000',      '',           'In stock [EN] šÄßüл', 'Out of stock [EN] šÄßüл',  0,       'testdistributor', 'testmanufacturer',  1,              1,             'DAY'),
                         ('1002',   1, '',            1,         '1002',     '[DE 2] Test product 2 šÄßüл', 'Test product 2 short desc [DE]', 55,        0,          0,          0,          0,         '',            0,                NULL,    0,          0,         1,            'In stock [DE]', 'Out of stock [DE]', '0000-00-00', '2008-02-04', '2008-02-04 17:18:18', 0,          0,         0,         'search1002',    1,           'variants [DE]',           10,           2,           '',             55,                67,                  'variants [EN] šÄßüл',     '',                'Test product 2 [EN] šÄßüл', 'Test product 2 short desc [EN] šÄßüл', 'šÄßüл1002',      '',           'In stock [EN] šÄßüл', 'Out of stock [EN] šÄßüл',  0,       'testdistributor', 'testmanufacturer',  1,              1,             'MONTH'),
                         ('1002-1', 1, '1002',        1,         '1002-1',   '',                            '',                               55,        45,         0,          0,          0,         '',            0,                NULL,    0,          5,         1,            'In stock [DE]', 'Out of stock [DE]', '0000-00-00', '2008-02-04', '2008-02-04 17:34:10', 0,          0,         0,         '',              1,           '',                        0,            0,           'var1 [DE]',    0,                 0,                   '',                        'var1 [EN] šÄßüл', '',                          '',                                     '',               '',           'In stock [EN] šÄßüл', 'Out of stock [EN] šÄßüл',  1,       '',                '',                  0,              0,             ''),
                         ('1002-2', 1, '1002',        1,         '1002-2',   '',                            '',                               67,        47,         0,          0,          0,         '',            0,                NULL,    0,          5,         1,            'In stock [DE]', 'Out of stock [DE]', '0000-00-00', '2008-02-04', '2008-02-04 17:34:36', 0,          0,         0,         '',              1,           '',                        0,            0,           'var2 [DE]',    0,                 0,                   '',                        'var2 [EN] šÄßüл', '',                          '',                                     '',               '',           'In stock [EN] šÄßüл', 'Out of stock [EN] šÄßüл',  2,       '',                '',                  0,              0,             ''),
                         ('1001',   1, '',            1,         '1001',     '[DE 1] Test product 1 šÄßüл', 'Test product 1 short desc [DE]', 100,       0,          0,          0,          150,       '',            0,                10,      0,          0,         1,            '',              '',                  '2030-01-01', '2008-02-04', '2008-02-04 17:35:49', 0,          0,         0,         'search1001',    1,           '',                        0,            0,           '',             100,               0,                   '',                        '',                'Test product 1 [EN] šÄßüл', 'Test product 1 short desc [EN] šÄßüл', 'šÄßüл1001',      '',           '',                    '',                         0,       'testdistributor', 'testmanufacturer',  0,              1,             'WEEK');

#Articles long desc
REPLACE INTO `oxartextends` (`OXID`,   `OXLONGDESC`,                                  `OXLONGDESC_1`) VALUES
                           ('1001',   '<p>Test product 1 long description [DE]</p>', '<p>Test product 1 long description [EN] šÄßüл</p>'),
                           ('1002',   '<p>Test product 2 long description [DE]</p>', '<p>Test product 2 long description [EN] šÄßüл</p>'),
                           ('1002-1', '',                                            ''),
                           ('1002-2', '',                                            ''),
                           ('1000',   '<p>Test product 0 long description [DE]</p>', '<p>Test product 0 long description [EN] šÄßüл</p>');

REPLACE INTO `oxcategories` (`OXID`,          `OXPARENTID`,   `OXLEFT`, `OXRIGHT`, `OXROOTID`,     `OXSORT`, `OXACTIVE`, `OXSHOPID`,   `OXTITLE`,                    `OXDESC`,                    `OXLONGDESC`,                `OXDEFSORT`, `OXDEFSORTMODE`, `OXPRICEFROM`, `OXPRICETO`, `OXACTIVE_1`, `OXTITLE_1`,                  `OXDESC_1`,                        `OXLONGDESC_1`,                    `OXVAT`, `OXSHOWSUFFIX`) VALUES
                           ('testcategory2', 'oxrootid',      1,        2,        'testcategory2', 1,        0,         1, 'Test category 2 [DE] šÄßüл', 'Test category 2 desc [DE]', 'Category 2 long desc [DE]', 'oxartnum',   0,               0,             0,           1,           'Test category 2 [EN] šÄßüл', 'Test category 2 desc [EN] šÄßüл', 'Category 2 long desc [EN] šÄßüл',  NULL,    1),
                           ('testcategory0', 'oxrootid',      1,        4,        'testcategory0', 1,        1,         1, 'Test category 0 [DE] šÄßüл', 'Test category 0 desc [DE]', 'Category 0 long desc [DE]', 'oxartnum',   0,               0,             0,           1,           'Test category 0 [EN] šÄßüл', 'Test category 0 desc [EN] šÄßüл', 'Category 0 long desc [EN] šÄßüл',  5,       1),
                           ('testcategory1', 'testcategory0', 2,        3,        'testcategory0', 2,        1,         1, 'Test category 1 [DE] šÄßüл', 'Test category 1 desc [DE]', 'Category 1 long desc [DE]', 'oxartnum',   1,               0,             0,           1,           'Test category 1 [EN] šÄßüл', 'Test category 1 desc [EN] šÄßüл', 'Category 1 long desc [EN] šÄßüл',  NULL,    1);

#Article2Category
REPLACE INTO `oxobject2category` (`OXID`,                       `OXOBJECTID`, `OXCATNID`,     `OXPOS`, `OXTIME`) VALUES
                                ('6f047a71f53e3b6c2.93342239', '1000',       'testcategory0', 0,       1202134867),
                                ('testobject2category', '1001',       'testcategory0', 0,       1202134867);

#Users demodata
REPLACE INTO `oxuser` (`OXID`,     `OXACTIVE`, `OXRIGHTS`, `OXSHOPID`,   `OXUSERNAME`,         `OXPASSWORD`,                       `OXPASSSALT`,        `OXCUSTNR`, `OXUSTID`, `OXCOMPANY`,          `OXFNAME`,        `OXLNAME`,           `OXSTREET`,        `OXSTREETNR`, `OXADDINFO`,                   `OXCITY`,            `OXCOUNTRYID`,                `OXZIP`, `OXFON`,        `OXFAX`,       `OXSAL`, `OXBONI`, `OXCREATE`,            `OXREGISTER`,          `OXPRIVFON`,   `OXMOBFON`,    `OXBIRTHDATE`) VALUES
                     ('testuser',  1,         'user',     1, 'example_test@oxid-esales.dev', 'c9dadd994241c9e5fa6469547009328a', '7573657275736572',   8,         '',        'UserCompany šÄßüл',  'UserNamešÄßüл',  'UserSurnamešÄßüл',  'Musterstr.šÄßüл', '1',          'User additional info šÄßüл',  'Musterstadt šÄßüл', 'a7c40f631fc920687.20179984', '79098',  '0800 111111', '0800 111112', 'Mr',     500,     '2008-02-05 14:42:42', '2008-02-05 14:42:42', '0800 111113', '0800 111114', '1980-01-01');

#object2Group
REPLACE INTO `oxobject2group` (`OXID`,                       `OXSHOPID`,   `OXOBJECTID`,   `OXGROUPSID`) VALUES
                             ('aad47a85a83749c71.33568408', 1, 'testuser',     'oxidnewcustomer');


# createBasketUserAccountWithoutRegistration
#adding states for germany
REPLACE INTO `oxstates` (`OXID`, `OXCOUNTRYID`, `OXTITLE`, `OXISOALPHA2`, `OXTITLE_1`, `OXTITLE_2`, `OXTITLE_3`) VALUES
('BB', 'a7c40f631fc920687.20179984', 'Brandenburg', 'BB', 'Brandenburg', '', ''),
('BE', 'a7c40f631fc920687.20179984', 'Berlin', 'BE', 'Berlin', '', ''),
('BW', 'a7c40f631fc920687.20179984', 'Baden-Württemberg', 'BW', 'Baden-Wurttemberg', '', ''),
('BY', 'a7c40f631fc920687.20179984', 'Bayern', 'BY', 'Bavaria', '', ''),
('HB', 'a7c40f631fc920687.20179984', 'Bremen', 'HB', 'Bremen', '', ''),
('HE', 'a7c40f631fc920687.20179984', 'Hessen', 'HE', 'Hesse', '', ''),
('HH', 'a7c40f631fc920687.20179984', 'Hamburg', 'HH', 'Hamburg', '', ''),
('MV', 'a7c40f631fc920687.20179984', 'Mecklenburg-Vorpommern', 'MV', 'Mecklenburg-Western Pomerania', '', ''),
('NI', 'a7c40f631fc920687.20179984', 'Niedersachsen', 'NI', 'Lower Saxony', '', ''),
('NW', 'a7c40f631fc920687.20179984', 'Nordrhein-Westfalen', 'NW', 'North Rhine-Westphalia', '', ''),
('RP', 'a7c40f631fc920687.20179984', 'Rheinland-Pfalz', 'RP', 'Rhineland-Palatinate', '', ''),
('SH', 'a7c40f631fc920687.20179984', 'Schleswig-Holstein', 'SH', 'Schleswig-Holstein', '', ''),
('SL', 'a7c40f631fc920687.20179984', 'Saarland', 'SL', 'Saarland', '', ''),
('SN', 'a7c40f631fc920687.20179984', 'Sachsen', 'SN', 'Saxony', '', ''),
('ST', 'a7c40f631fc920687.20179984', 'Sachsen-Anhalt', 'ST', 'Saxony-Anhalt', '', ''),
('TH', 'a7c40f631fc920687.20179984', 'Thüringen', 'TH', 'Thuringia', '', '');


# createBasketUserAccountWithoutRegistration
UPDATE `oxconfig` SET `OXVARVALUE` = 0xde         WHERE `OXVARNAME` = 'iNewBasketItemMessage';
UPDATE `oxconfig` SET `OXVARVALUE` = ''           WHERE `OXVARNAME` = 'blDisableNavBars';
REPLACE INTO `oxconfig` (`OXID`, `OXSHOPID`, `OXMODULE`,   `OXVARNAME`,                     `OXVARTYPE`, `OXVARVALUE`) VALUES
                       ('4742', 1, '', 'blPerfNoBasketSaving',          'bool',       0x93ea1218),
                       ('8563fba1965a219c9.51133344', 1, '', 'blUseStock',          'bool',       0x93ea1218);

# createBasketUserAccountWithoutRegistrationTwice
UPDATE `oxcountry` SET `OXACTIVE` = 1 WHERE `OXTITLE_1` = 'Belgium';

# userCompareList
#Article2Attribute
REPLACE INTO `oxobject2attribute` (`OXID`,                       `OXOBJECTID`, `OXATTRID`,       `OXVALUE`,           `OXPOS`, `OXVALUE_1`) VALUES
                                 ('aad47a8511f54e023.54090494', '1000',       'testattribute1', 'attr value 1 [DE]',  0,      'attr value 1 [EN] šÄßüл'),
                                 ('aad47a8511f556f17.20889862', '1001',       'testattribute1', 'attr value 11 [DE]', 0,      'attr value 11 [EN] šÄßüл'),
                                 ('aad47a85125a41ed7.53096100', '1000',       'testattribute2', 'attr value 2 [DE]',  0,      'attr value 2 [EN] šÄßüл'),
                                 ('aad47a85125a4aa05.37412863', '1001',       'testattribute2', 'attr value 12 [DE]', 0,      'attr value 12 [EN] šÄßüл'),
                                 ('aad47a8512d783995.31168870', '1000',       'testattribute3', 'attr value 3 [DE]',  0,      'attr value 3 [EN] šÄßüл'),
                                 ('aad47a8512d78c354.06494034', '1001',       'testattribute3', 'attr value 3 [DE]',  0,      'attr value 3 [EN] šÄßüл');

#Attributes demodata
REPLACE INTO `oxattribute` (`OXID`,           `OXSHOPID`,   `OXTITLE`,                     `OXTITLE_1`,                  `OXPOS`) VALUES
                          ('testattribute1', 1, 'Test attribute 1 [DE] šÄßüл', 'Test attribute 1 [EN] šÄßüл', 1),
                          ('testattribute2', 1, 'Test attribute 2 [DE] šÄßüл', 'Test attribute 2 [EN] šÄßüл', 3),
                          ('testattribute3', 1, 'Test attribute 3 [DE] šÄßüл', 'Test attribute 3 [EN] šÄßüл', 2);
UPDATE `oxattribute` SET `OXDISPLAYINBASKET` = 0;

#set country, username, password for default user
UPDATE oxuser
  SET
      oxcountryid = 'a7c40f631fc920687.20179984',
      oxusername = 'admin@myoxideshop.com',
      oxpassword = '6cb4a34e1b66d3445108cd91b67f98b9',
      oxpasssalt = '6631386565336161636139613634663766383538633566623662613036636539'
  WHERE OXUSERNAME='admin';

REPLACE INTO `oxdiscount` (`OXID`,            `OXSHOPID`,  `OXACTIVE`, `OXTITLE`,                          `OXTITLE_1`,             `OXAMOUNT`, `OXAMOUNTTO`, `OXPRICETO`, `OXPRICE`, `OXADDSUMTYPE`, `OXADDSUM`, `OXITMARTID`, `OXITMAMOUNT`, `OXITMMULTIPLE`, `OXSORT`) VALUES
                         ('testcatdiscount', 1, 0,         'discount for category [DE] šÄßüл', 'discount for category [EN] šÄßüл',  1,          999999,       0,           0,        'abs',           5,         '',            0,             0,               100);

#object2discount
REPLACE INTO `oxobject2discount` (`OXID`,                        `OXDISCOUNTID`,    `OXOBJECTID`,                 `OXTYPE`) VALUES
                                ('fa647a823ce118996.58546955',  'testcatdiscount', 'a7c40f631fc920687.20179984', 'oxcountry'),
                                ('fa647a823d5079104.99115703',  'testcatdiscount', 'testcategory0',              'oxcategories');

#Coupons demodata
REPLACE INTO `oxvoucherseries` (`OXID`,         `OXSHOPID`,   `OXSERIENR`,           `OXSERIEDESCRIPTION`,      `OXDISCOUNT`, `OXDISCOUNTTYPE`, `OXBEGINDATE`,         `OXENDDATE`,          `OXALLOWSAMESERIES`, `OXALLOWOTHERSERIES`, `OXALLOWUSEANOTHER`, `OXMINIMUMVALUE`, `OXCALCULATEONCE`) VALUES
                              ('testvoucher4', 1, '4 Coupon šÄßüл',      '4 Coupon šÄßüл',           50.00,       'percent',        '2008-01-01 00:00:00', now() + interval 1 day, 0,                   0,                    0,                   45.00,            1);

REPLACE INTO `oxvouchers` (`OXDATEUSED`, `OXRESERVED`, `OXVOUCHERNR`, `OXVOUCHERSERIEID`, `OXID`) VALUES
                         ('0000-00-00',  0,           '123123',      'testvoucher4',     'testcoucher011');

#Gift wrapping demodata
REPLACE INTO `oxwrapping` (`OXID`,         `OXSHOPID`,  `OXACTIVE`, `OXACTIVE_1`, `OXACTIVE_2`, `OXACTIVE_3`, `OXTYPE`, `OXNAME`,                        `OXNAME_1`,                     `OXPRICE`) VALUES
                         ('testwrapping', 1, 1,          1,            1,            1,           'WRAP',   'Test wrapping [DE] šÄßüл',      'Test wrapping [EN] šÄßüл',      0.9),
                         ('testcard',     1, 1,          1,            1,            1,           'CARD',   'Test card [DE] šÄßüл',          'Test card [EN] šÄßüл',          0.2);

#Select list demodata
REPLACE INTO `oxselectlist` (`OXID`,          `OXSHOPID`,   `OXTITLE`,                        `OXIDENT`,              `OXVALDESC`,                                                                      `OXTITLE_1`,                      `OXVALDESC_1`) VALUES
                           ('testsellist',   1, 'test selection list [DE] šÄßüл', 'test sellist šÄßüл',   'selvar1 [DE]!P!1__@@selvar2 [DE]__@@selvar3 [DE]!P!-2__@@selvar4 [DE]!P!2%__@@', 'test selection list [EN] šÄßüл', 'selvar1 [EN] šÄßüл!P!1__@@selvar2 [EN] šÄßüл__@@selvar3 [EN] šÄßüл!P!-2__@@selvar4 [EN] šÄßüл!P!2%__@@');

#Article2SelectList
REPLACE INTO `oxobject2selectlist` (`OXID`,                       `OXOBJECTID`, `OXSELNID`,   `OXSORT`) VALUES
                                  ('testsellist.1001', '1001',       'testsellist', 0);


#
# Data for table `oxdel2delset`
#
INSERT INTO `oxdel2delset` (`OXID`, `OXDELID`, `OXDELSETID`) VALUES
  ('5be44bc9261862fc4.78617917', '1b842e734b62a4775.45738618', 'oxidstandard'),
  ('4ba44c7251a587071.83952129', '1b842e73470578914.54719298', 'oxidstandard'),
  ('4ba44c72528a26008.03376396', '1b842e7352422a708.01472527', 'oxidstandard'),
  ('4ba44c7252d6d5785.89997750', '1b842e738970d31e3.71258327', '1b842e732a23255b1.91207750'),
  ('4ba44c7252d6d5785.89997751', '1b842e738970d31e3.71258328', '1b842e732a23255b1.91207751');

#
# Data for table `oxdelivery`
#
INSERT INTO `oxdelivery` (`OXID`, `OXSHOPID`, `OXACTIVE`, `OXACTIVEFROM`, `OXACTIVETO`, `OXTITLE`, `OXTITLE_1`, `OXTITLE_2`, `OXTITLE_3`, `OXADDSUMTYPE`, `OXADDSUM`, `OXDELTYPE`, `OXPARAM`, `OXPARAMEND`, `OXFIXED`, `OXSORT`, `OXFINALIZE`) VALUES
  ('1b842e734b62a4775.45738618', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Versandkosten für Standard: Versandkostenfrei ab 80,-', 'Shipping costs for Standard: Free shipping for orders over $80', '', '', 'abs', 0, 'p', 80, 999999, 0, 1000, 1),
  ('1b842e73470578914.54719298', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Versandkosten für Standard: 3,90 Euro innerhalb Deutschland', 'Shipping costs for Standard: $3.90 for domestic shipping', '', '', 'abs', 3.9, 'p', 0, 79.99, 0, 2000, 1),
  ('1b842e7352422a708.01472527', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Versandkosten für Standard: 6,90 Rest EU', 'Shipping costs for Standard: $6.90 to ship in the rest of the EU', '', '', 'abs', 6.9, 'p', 0, 999999, 0, 3000, 1),
  ('1b842e738970d31e3.71258327', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Versandkosten für Beispiel Set1: UPS 48 Std.: 9,90.-', 'Shipping costs for Example Set1: UPS 48 hrs: $9.90', '', '', 'abs', 9.9, 'p', 0, 99999, 0, 4000, 1),
  ('1b842e738970d31e3.71258328', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Versandkosten für Beispiel Set2: UPS 24 Std. Express: 12,90.-', 'Shipping costs for Example Set2: UPS 24 hrs Express: $12.90', '', '', 'abs', 12.9, 'p', 0, 99999, 0, 5000, 1);

#
# Data for table `oxdeliveryset`
#
INSERT INTO `oxdeliveryset` (`OXID`, `OXSHOPID`, `OXACTIVE`, `OXACTIVEFROM`, `OXACTIVETO`, `OXTITLE`, `OXTITLE_1`, `OXTITLE_2`, `OXTITLE_3`, `OXPOS`) VALUES
  ('1b842e732a23255b1.91207750', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Beispiel Set1: UPS 48 Std.', 'Example Set1: UPS 48 hours', '', '', 30),
  ('1b842e732a23255b1.91207751', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Beispiel Set1: UPS 24 Std. Express', 'Example Set2: UPS Express 24 hours', '', '', 30);

#
# Data for table `oxobject2group`
#
INSERT INTO `oxobject2group` (`OXID`, `OXSHOPID`, `OXOBJECTID`, `OXGROUPSID`) VALUES
  ('f1d3fdd845d646ce0.54037160', 1, 'oxidcashondel', 'oxidsmallcust'),
  ('f1d3fdd845d64f368.38782882', 1, 'oxidcashondel', 'oxidmiddlecust'),
  ('f1d3fdd845d655500.24044370', 1, 'oxidcashondel', 'oxidgoodcust'),
  ('f1d3fdd845d664a36.22008654', 1, 'oxidcashondel', 'oxidforeigncustomer'),
  ('f1d3fdd845d66bfa6.86175113', 1, 'oxidcashondel', 'oxidnewcustomer'),
  ('f1d3fdd845d671e32.96237048', 1, 'oxidcashondel', 'oxidpowershopper'),
  ('f1d3fdd845d67e7c5.10668991', 1, 'oxidcashondel', 'oxiddealer'),
  ('f1d3fdd845d6896c1.03162238', 1, 'oxidcashondel', 'oxidnewsletter'),
  ('f1d3fdd845d691ec8.81166485', 1, 'oxidcashondel', 'oxidadmin'),
  ('f1d3fdd845d69e885.91443232', 1, 'oxidcashondel', 'oxidpriceb'),
  ('f1d3fdd845d6a67e0.02859671', 1, 'oxidcashondel', 'oxidpricea'),
  ('f1d3fdd845d6ad995.44313456', 1, 'oxidcashondel', 'oxidpricec'),
  ('c193fddd471979db5.85262084', 1, 'oxiddebitnote', 'oxidsmallcust'),
  ('c193fddd471987391.56507198', 1, 'oxiddebitnote', 'oxidnewcustomer'),
  ('c193fddd4719915f1.10073644', 1, 'oxiddebitnote', 'oxidnewsletter'),
  ('c193fddd4719996f2.77898155', 1, 'oxiddebitnote', 'oxidadmin'),
  ('c193fddd4831e2713.21232210', 1, 'oxidcreditcard', 'oxidsmallcust'),
  ('c193fddd4831f6f46.50917349', 1, 'oxidcreditcard', 'oxidmiddlecust'),
  ('c193fddd4831ff385.99230154', 1, 'oxidcreditcard', 'oxidgoodcust'),
  ('c193fddd483207c10.92807988', 1, 'oxidcreditcard', 'oxidforeigncustomer'),
  ('c193fddd483215d21.77186691', 1, 'oxidcreditcard', 'oxidnewcustomer'),
  ('c193fddd48321e633.40782090', 1, 'oxidcreditcard', 'oxidpowershopper'),
  ('c193fddd483225762.33412275', 1, 'oxidcreditcard', 'oxiddealer'),
  ('c193fddd483233a87.07118337', 1, 'oxidcreditcard', 'oxidnewsletter'),
  ('c193fddd48323bcb8.16273041', 1, 'oxidcreditcard', 'oxidadmin'),
  ('c193fddd483242bc6.72020207', 1, 'oxidcreditcard', 'oxidpriceb'),
  ('c193fddd483251c35.30210206', 1, 'oxidcreditcard', 'oxidpricea'),
  ('c193fddd48325a223.07587162', 1, 'oxidcreditcard', 'oxidpricec'),
  ('c193fddd4939c95b3.22730175', 1, 'oxidinvoice', 'oxidnewcustomer'),
  ('c193fddd49772de88.87420931', 1, 'oxidinvoice', 'oxidgoodcust'),
  ('c193fddd49b560bf7.83973615', 1, 'oxidpayadvance', 'oxidblacklist'),
  ('c193fddd49b578c58.17144323', 1, 'oxidpayadvance', 'oxidsmallcust'),
  ('c193fddd49b581dd2.00588439', 1, 'oxidpayadvance', 'oxidmiddlecust'),
  ('c193fddd49b591ad7.64823006', 1, 'oxidpayadvance', 'oxidgoodcust'),
  ('c193fddd49b599565.04338675', 1, 'oxidpayadvance', 'oxidforeigncustomer'),
  ('c193fddd49b5a06b3.75268916', 1, 'oxidpayadvance', 'oxidnewcustomer'),
  ('c193fddd49b5b5021.38970407', 1, 'oxidpayadvance', 'oxidpowershopper'),
  ('c193fddd49b5bd575.90280311', 1, 'oxidpayadvance', 'oxiddealer'),
  ('c193fddd49b5cc515.90816240', 1, 'oxidpayadvance', 'oxidnewsletter'),
  ('c193fddd49b5d43e6.35256824', 1, 'oxidpayadvance', 'oxidadmin'),
  ('c193fddd49b5db4e8.17741481', 1, 'oxidpayadvance', 'oxidpriceb'),
  ('c193fddd49b5ed246.01214326', 1, 'oxidpayadvance', 'oxidpricea'),
  ('c193fddd49b5f65d4.60703125', 1, 'oxidpayadvance', 'oxidpricec'),
  ('dfc42e744180bf4a9.98598495', 1, 'dfc42e74417f07347.45624764', 'oxidnewcustomer'),
  ('92044c0db9271e5b8.58103839', 1, '92044c0db9220e842.85595739', 'oxidnewcustomer'),
  ('e7a7197c7cf8e878e8ff2c18645788ab', 1, 'e7af1c3b786fd02906ccd75698f4e6b9', 'oxidnewcustomer'),
  ('e7a3bc0ffde37901c6c1be9bdd43b9a5', 1, 'e7af1c3b786fd02906ccd75698f4e6b9', 'oxidcustomer'),
  ('e7a50c8a8a31cb82b8ae4b38c64a78ba', 1, 'e7af1c3b786fd02906ccd75698f4e6b9', 'oxidgoodcust'),
  ('e5d1d2defe53c30aeca0f86bde4ae531', 1, 'e7af1c3b786fd02906ccd75698f4e6b9', 'oxidmiddlecust'),
  ('515d07c92d6f3178601adb83ab50d747', 1, '5158381d9da5cc40384c50600991c74f', 'oxidnewcustomer'),
  ('515eeb3573a79d8ff8dd90dcf9a3ac3e', 1, '5158381d9da5cc40384c50600991c74f', 'oxidnotyetordered');


#
# Data for table `oxobject2payment`
#
INSERT INTO `oxobject2payment` (`OXID`, `OXPAYMENTID`, `OXOBJECTID`, `OXTYPE`) VALUES
  ('92d4214bf673df592.85542338', 'oxidpayadvance', 'a434214960877b879.20979568', 'oxdelset'),
  ('1b842e7375676dd84.15824521', 'oxidinvoice', 'oxidstandard', 'oxdelset'),
  ('1b842e737567681b7.32408586', 'oxidpayadvance', 'oxidstandard', 'oxdelset'),
  ('1b842e73756761653.33874589', 'oxiddebitnote', 'oxidstandard', 'oxdelset'),
  ('1b842e7375675b807.24061946', 'oxidcreditcard', 'oxidstandard', 'oxdelset'),
  ('f324215af5c89b870.26091752', 'oxidcreditcard', 'f324215af31591936.94392085', 'oxdelset'),
  ('f324215af5c8be899.90598822', 'oxiddebitnote', 'f324215af31591936.94392085', 'oxdelset'),
  ('1b842e737567541b1.16932982', 'oxidcashondel', 'oxidstandard', 'oxdelset'),
  ('0f941664de07fe713.78180932', 'oxiddebitnote', 'a7c40f631fc920687.20179984', 'oxcountry'),
  ('0f941664de081d815.03693723', 'oxiddebitnote', 'a7c40f6320aeb2ec2.72885259', 'oxcountry'),
  ('0f941664de082a1b0.85265324', 'oxiddebitnote', 'a7c40f6321c6f6109.43859248', 'oxcountry'),
  ('0f941664e70744a73.85113769', 'oxidcreditcard', 'a7c40f631fc920687.20179984', 'oxcountry'),
  ('0f941664e70758467.23169947', 'oxidcreditcard', 'a7c40f6320aeb2ec2.72885259', 'oxcountry'),
  ('0f941664e707657e4.30674465', 'oxidcreditcard', 'a7c40f6321c6f6109.43859248', 'oxcountry'),
  ('0f941664e9e60f698.58333517', 'oxidcashondel', 'a7c40f631fc920687.20179984', 'oxcountry'),
  ('0f941664ee2448a22.44967166', 'oxidinvoice', 'a7c40f631fc920687.20179984', 'oxcountry'),
  ('0f941664ee245e458.07911799', 'oxidinvoice', 'a7c40f6320aeb2ec2.72885259', 'oxcountry'),
  ('0f941664ee246ac84.39868591', 'oxidinvoice', 'a7c40f6321c6f6109.43859248', 'oxcountry'),
  ('0f941664efa30a021.06837665', 'oxidpayadvance', 'a7c40f631fc920687.20179984', 'oxcountry'),
  ('0f941664efa320ca8.35650805', 'oxidpayadvance', 'a7c40f6320aeb2ec2.72885259', 'oxcountry'),
  ('0f941664efa32d4e5.28625433', 'oxidpayadvance', 'a7c40f6321c6f6109.43859248', 'oxcountry'),
  ('1b842e738b3f1ca46.72529947', 'oxidcreditcard', '1b842e732a23255b1.91207750', 'oxdelset'),
  ('1b842e738b3f1ca46.72529948', 'oxidcreditcard', '1b842e732a23255b1.91207751', 'oxdelset');
