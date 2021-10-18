<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211018032331 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create `movement` table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE `movement` (
                id CHAR(36) NOT NULL PRIMARY KEY,
                category_movement_id CHAR(36) NOT NULL,
                owner_id CHAR(36) NOT NULL,
                group_id CHAR(36) DEFAULT NULL,
                amount DECIMAL(8,2) NOT NULL,
                file_path VARCHAR(255) DEFAULT NULL,
                created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                
                INDEX IDX_movement_category_movement_id (category_movement_id),
                INDEX IDX_movement_owner_id (owner_id),
                INDEX IDX_movement_group_id (group_id),
                
                CONSTRAINT FK_movement_category_movement_id FOREIGN KEY (category_movement_id) REFERENCES `categorymovement` (id) ON UPDATE CASCADE ON DELETE CASCADE,
                CONSTRAINT FK_movement_owner_id FOREIGN KEY (owner_id) REFERENCES `user` (id) ON UPDATE CASCADE ON DELETE CASCADE,
                CONSTRAINT FK_movement_group_id FOREIGN KEY (group_id) REFERENCES `user_groups` (id) ON UPDATE CASCADE ON DELETE CASCADE
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE InnoDB '
        );
    }

    public function down(Schema $schema): void
    {
       $this->addSql('DROP TABLE `movements`');

    }
}
