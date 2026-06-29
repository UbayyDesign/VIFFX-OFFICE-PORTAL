# Database Audit Report

This file will be populated by the automated audit and cleanup steps. It summarizes tables, unused columns, unused foreign keys, and migrations generated to remove unused database objects.

Current status:

- Initial report created: migration added to introduce `notifications` table for Laravel database notifications.

Next steps:

- Run migrations: `php artisan migrate` to add `notifications` table.
- Perform full schema analysis and record unused tables/columns.
