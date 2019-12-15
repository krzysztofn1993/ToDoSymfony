<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191215151121 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB2581952EA0');
        $this->addSql('DROP INDEX IDX_527EDB2581952EA0 ON task');
        $this->addSql('ALTER TABLE task CHANGE task_user_id_id task_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25B88FF97F FOREIGN KEY (task_user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_527EDB25B88FF97F ON task (task_user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB25B88FF97F');
        $this->addSql('DROP INDEX IDX_527EDB25B88FF97F ON task');
        $this->addSql('ALTER TABLE task CHANGE task_user_id task_user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB2581952EA0 FOREIGN KEY (task_user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_527EDB2581952EA0 ON task (task_user_id_id)');
    }
}
