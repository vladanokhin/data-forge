DROP TABLE IF EXISTS `metrics`;

CREATE TABLE IF NOT EXISTS `metrics` (
    `id`            BIGINT NOT NULL AUTO_INCREMENT KEY,
    `ad_id`         BIGINT NOT NULL UNIQUE,
    `impressions`   INT(10) DEFAULT NULL,
    `clicks`        INT(10) DEFAULT NULL,
    `unique_clicks` INT(10) DEFAULT NULL,
    `leads`         INT(10) DEFAULT NULL,
    `conversion`    INT(10) DEFAULT NULL,
    `roi`           INT(5) DEFAULT NULL
);
