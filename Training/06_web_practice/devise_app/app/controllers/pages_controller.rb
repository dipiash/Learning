class PagesController < ApplicationController

  before_filter :authenticate_user!, except: [:index]

  def index
  end

  def info
    @info = "Only signed in users!"
  end
end
