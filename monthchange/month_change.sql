CREATE TABLE receipts_JamadalAwwal AS SELECT * FROM receipts;
TRUNCATE TABLE receipts;
CREATE TABLE thalilist_JamadalAwwal AS SELECT * FROM thalilist;
UPDATE thalilist SET Previous_Due = Total_Pending;
UPDATE thalilist SET Dues = 0, Zabihat = 0, Reg_Fee = 0, TranspFee = 0, Paid = 0;
UPDATE thalilist SET Dues = 1800 where Active = 1;
UPDATE thalilist SET TranspFee = 250 where Active = 1 AND Transporter != 'Pick Up';

-- Customization

-- Sadhashive peth
UPDATE thalilist SET TranspFee = 350 where Active = 1 AND Transporter != 'Pick Up' AND Thali IN (9,410,602);

-- Kothrud
UPDATE thalilist SET TranspFee = 500 where Active = 1 AND Transporter != 'Pick Up' AND Thali IN (202,593,594,595,596,615,600,629);

-- Saif Colony
UPDATE thalilist SET TranspFee = 400 where Active = 1 AND Transporter != 'Pick Up' AND Thali IN (237,520);

-- Hoob adjust
UPDATE thalilist SET Dues = 1400 where Active = 1 AND Thali IN (553,548,618,619,620);
UPDATE thalilist SET Dues = 1000 where Active = 1 AND Thali IN (41);
UPDATE thalilist SET Dues = 1100 where Active = 1 AND Thali IN (112,598);
UPDATE thalilist SET Dues = 1500 where Active = 1 AND Thali IN (431);
