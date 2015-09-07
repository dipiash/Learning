Rails.application.routes.draw do
  devise_for :users

  root 'pages#index'

  get 'info', to: 'pages#info', via: 'get'
end
