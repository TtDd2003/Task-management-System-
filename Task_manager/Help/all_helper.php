<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Helper Assignments</title>
    <link rel="stylesheet" type="text/css" href="../asset/css/all_helper.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Helper Assignments</h1>
            <p>Track and manage helper assignments across your organization</p>
        </div>

         <div class="search-container">
            <div class="search-box">
                <input type="text" id="searchInput" class="search-input" placeholder="Search helpers by name or skills...">
               <select id="statusFilter" class="filter-select">
                    <option value="all">All Status</option>
                    <option value="high">high</option>
                    <option value="medium">medium</option>
                    <option value="low">low</option>
                </select>

                <select id="sortBy" class="filter-select">
                    <option value="name">Sort by Name</option>
                    <option value="rating">Sort by Rating</option>
                    <option value="assignments">Sort by Assignments</option>
                </select>
            </div>
        </div>

        <div class="stats-container">
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-number" id="total-helpers">0</div>
                    <div class="stat-label">Total Helpers</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number" id="available-helpers">0</div>
                    <div class="stat-label">Available</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number" id="busy-helpers">0</div>
                    <div class="stat-label">Busy</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number" id="assigned-helpers">0</div>
                    <div class="stat-label">Assigned</div>
                </div>
            </div>
        </div>

        

        <div class="helpers-grid" id="helpersGrid">
            <!-- Helper cards will be dynamically generated here -->
        </div>
    </div>

    
    <script src="../asset/js/help.js"></script>
</body>
</html>

