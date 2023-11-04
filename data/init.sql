DROP TABLE IF EXISTS `statistics`;
CREATE TABLE IF NOT EXISTS `statistics`
(
    `id`            INT(10) NOT NULL AUTO_INCREMENT KEY,
    `ad_id`         INT(10) NOT NULL,
    `impressions`   INT(10) DEFAULT NULL,
    `clicks`        INT(10) DEFAULT NULL,
    `unique_clicks` INT(10) DEFAULT NULL,
    `leads`         INT(10) DEFAULT NULL,
    `conversion`    INT(10) DEFAULT NULL,
    `roi`           FLOAT(10) DEFAULT NULL
);
