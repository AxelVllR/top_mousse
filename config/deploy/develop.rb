set :stage, :prod

set :ssh_user, 'axelvllr'
server '86.210.114.247', user: fetch(:ssh_user), roles: %w{web app db}

set :branch, 'develop'
#path for the deploy
set :deploy_to, '/home/axelvllr/public_html/prod'