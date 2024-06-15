CREATE SCHEMA public;
DROP SEQUENCE doctor_profile_id_seq CASCADE;
DROP SEQUENCE medical_specialisation_id_seq CASCADE;
ALTER TABLE doctor_profile DROP CONSTRAINT FK_12FAC9A26F992C8B;
DROP TABLE doctor_profile;
DROP TABLE medical_specialisation;
