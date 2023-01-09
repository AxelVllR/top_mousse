  namespace :db do
    desc 'Force database update'
    task :database_force do
         on roles(:app) do
              symfony_console "doctrine:schema:update", "--force"
         end
    end
  
    desc 'Database validate'
    task :database_validate do
         on roles(:app) do
              symfony_console "doctrine:schema:validate"
         end
    end
    after 'deploy:updated', 'db:database_force'
    after 'db:database_force', 'db:database_validate'
  end
  namespace :symfony do
    desc "Clear apc cache"
    task :clear_apc do
       on roles(:app) do
              symfony_console "cache:accelerator:clear"
   end
   end
  end