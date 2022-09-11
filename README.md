# Venture Dashboard

## Install

```bash
composer require sassnowski/venture-dashboard
```

After install, publish its assets running:

```bash
php artisan venture:dashboard:install // TODO
```

## Configuration

// TODO: Publish the ServiceProvider to modify the Gate and the Base Route.

// "Dashboard Authorization"

## Contribute: To-do

- [ ] JsonResources for API endpoints
- [ ] Improve Job's name (php unserialize)
- [ ] Replace cytoscape for mermaid? (maybe)
- [ ] Live-refresh on unfinished Workflow
- [ ] Add overview stats:
  - Workflows created in the last day
  - Workflows finished in the last day
  - Workflows failed in the last day
- [ ] Finish readme

Advanced:
- [ ] Publish a migration with db indexes for this dashboard.
- [ ] Re-try failed workflow.
- [ ] Show elapsed time between started (added to the queue) and finished.
  - The main drive here is to see which jobs are the slowest.

## Credits

- [Kai Sassnowski](https://github.com/ksassnowski)
- [All contributors](https://github.com/ksassnowski/venture/contributors)
