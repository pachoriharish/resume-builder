-- ResumeForge schema (for hosts where the database is created in the control panel)
-- Select your database in phpMyAdmin first, then import.

DROP TABLE IF EXISTS educations;
DROP TABLE IF EXISTS experiences;
DROP TABLE IF EXISTS resumes;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id        INT UNSIGNED NOT NULL AUTO_INCREMENT,
    email     VARCHAR(191) NOT NULL,
    password  VARCHAR(255) NOT NULL,
    created   DATETIME NULL,
    modified  DATETIME NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uq_users_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE resumes (
    id         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    user_id    INT UNSIGNED NOT NULL,
    template   VARCHAR(20)  NOT NULL DEFAULT 'classic',
    full_name  VARCHAR(150) NOT NULL,
    email      VARCHAR(191) NOT NULL,
    phone      VARCHAR(50)  NULL,
    address    VARCHAR(255) NULL,
    summary    TEXT NULL,
    skills     TEXT NULL,
    created    DATETIME NULL,
    modified   DATETIME NULL,
    PRIMARY KEY (id),
    KEY idx_resumes_user (user_id),
    CONSTRAINT fk_resumes_user FOREIGN KEY (user_id)
        REFERENCES users (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE experiences (
    id           INT UNSIGNED NOT NULL AUTO_INCREMENT,
    resume_id    INT UNSIGNED NOT NULL,
    company      VARCHAR(150) NOT NULL,
    job_title    VARCHAR(150) NULL,
    start_date   VARCHAR(30)  NULL,
    end_date     VARCHAR(30)  NULL,
    description  TEXT NULL,
    PRIMARY KEY (id),
    KEY idx_experiences_resume (resume_id),
    CONSTRAINT fk_experiences_resume FOREIGN KEY (resume_id)
        REFERENCES resumes (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE educations (
    id          INT UNSIGNED NOT NULL AUTO_INCREMENT,
    resume_id   INT UNSIGNED NOT NULL,
    school      VARCHAR(150) NOT NULL,
    degree      VARCHAR(150) NULL,
    start_year  VARCHAR(10)  NULL,
    end_year    VARCHAR(10)  NULL,
    PRIMARY KEY (id),
    KEY idx_educations_resume (resume_id),
    CONSTRAINT fk_educations_resume FOREIGN KEY (resume_id)
        REFERENCES resumes (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;