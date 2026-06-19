CREATE TABLE IF NOT EXISTS lophoc (
    malop varchar(20) NOT NULL,
    tenlop varchar(100) NOT NULL,
    namhoc varchar(20) NOT NULL DEFAULT '',
    PRIMARY KEY (malop)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT IGNORE INTO lophoc (malop, tenlop, namhoc)
SELECT DISTINCT lop, lop, ''
FROM sinhvien
WHERE lop IS NOT NULL AND lop <> '';

ALTER TABLE sinhvien CHANGE lop malop varchar(20) NOT NULL;

ALTER TABLE sinhvien
    ADD CONSTRAINT fk_sinhvien_lophoc
    FOREIGN KEY (malop) REFERENCES lophoc(malop)
    ON UPDATE CASCADE
    ON DELETE RESTRICT;