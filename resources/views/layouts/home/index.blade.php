@extends('layouts.app')

@section('content')
    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h1>Welcome to a E-Ticket System</h1></div>

                    <div class="card-body">
                        <h1 class="text-success"></h1>
                        <div class="mt-3">
                            <p>The E-Ticket System is a management tool to manage your Project, Sprint, Tickets and User.</p>
                            <p>The Project is for all and it is under the General Public License.</p>
                            <h3 class="text-primary">Lets start Agile.</h3>
                        <div>
                        <div class="row mt-4">
                            <div class="col-4">
                                <div class="list-group" id="list-tab" role="tablist">
                                    <a class="list-group-item list-group-item-action active" id="list-outlook-list" data-toggle="list" href="#list-outlook" role="tab" aria-controls="outlook">Outlook</a>
                                    <a class="list-group-item list-group-item-action" id="list-kanban-list" data-toggle="list" href="#list-kanban" role="tab" aria-controls="kanban">Kanban</a>
                                    <a class="list-group-item list-group-item-action" id="list-scrum-list" data-toggle="list" href="#list-scrum" role="tab" aria-controls="scrum">Scrum</a>
                                </div>
                            </div>

                            <div class="col-8">
                                <div class="tab-content" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="list-outlook" role="tabpanel" aria-labelledby="list-outlook-list">
                                        <ul class="list-unstyled">
                                            <li>1. Statistics for Tickets by Project and Sprints.</li>
                                            <li>2. Time line for the Sprint with the Status.</li>
                                        </ul>
                                    </div>

                                    <div class="tab-pane fade" id="list-kanban" role="tabpanel" aria-labelledby="list-kanban-list">
                                        <ul class="list-unstyled">
                                            <li>1. Create a Project with a method Kanban.</li>
                                            <li>2. Create your Tickets.</li>
                                            <li>3. In the Kanban Dashboard if you see 10 tickets in the Backlog.</li>
                                        </ul>
                                    </div>

                                    <div class="tab-pane fade" id="list-scrum" role="tabpanel" aria-labelledby="list-scrum-list">
                                        <ul class="list-unstyled">
                                            <li>1. Create a Project with a method Scrum.</li>
                                            <li>2. Create a Sprint.</li>
                                            <li>3. Create your Tickets.</li>
                                            <li>4. Edit the Tickets and order the Tickets to your Sprint.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
