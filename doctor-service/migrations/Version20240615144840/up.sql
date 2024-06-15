CREATE SEQUENCE doctor_profile_id_seq INCREMENT BY 1 MINVALUE 1 START 1;
CREATE SEQUENCE medical_specialisation_id_seq INCREMENT BY 1 MINVALUE 1 START 1;
CREATE TABLE doctor_profile
(
    id                        INT          NOT NULL,
    medical_specialisation_id INT          NOT NULL,
    name                      VARCHAR(128) NOT NULL,
    second_name               VARCHAR(128) DEFAULT NULL,
    surname                   VARCHAR(128) NOT NULL,
    npwz                      VARCHAR(10)  NOT NULL,
    working_time              JSON         NOT NULL,
    PRIMARY KEY (id)
);
CREATE UNIQUE INDEX UNIQ_12FAC9A27EE2406F ON doctor_profile (npwz);
CREATE INDEX IDX_12FAC9A26F992C8B ON doctor_profile (medical_specialisation_id);
CREATE TABLE medical_specialisation
(
    id    INT          NOT NULL,
    title VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);
ALTER TABLE doctor_profile
    ADD CONSTRAINT FK_12FAC9A26F992C8B FOREIGN KEY (medical_specialisation_id) REFERENCES medical_specialisation (id) NOT DEFERRABLE INITIALLY IMMEDIATE;
