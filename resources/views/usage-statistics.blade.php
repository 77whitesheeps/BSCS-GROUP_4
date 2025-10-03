<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planting System - Usage Analytics</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }
        
        .stat-card {
            transition: all 0.3s ease;
            border-radius: 12px;
            overflow: hidden;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .progress-ring {
            transform: rotate(-90deg);
        }
        
        .chart-container {
            position: relative;
            height: 100%;
            width: 100%;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }
        
        .trend-up {
            color: #10b981;
        }
        
        .trend-down {
            color: #ef4444;
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Planting System Analytics</h1>
                <p class="text-gray-600 mt-2">Comprehensive overview of system usage and performance metrics</p>
            </div>
            <div class="mt-4 md:mt-0 flex items-center space-x-4">
                <div class="relative">
                    <select class="appearance-none bg-white border border-gray-300 rounded-lg py-2 pl-3 pr-8 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        <option>Last 7 days</option>
                        <option selected>Last 30 days</option>
                        <option>Last 90 days</option>
                        <option>Last year</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <i class="fas fa-chevron-down text-xs"></i>
                    </div>
                </div>
                <button class="bg-white border border-gray-300 rounded-lg py-2 px-4 text-sm flex items-center space-x-2 hover:bg-gray-50 transition-colors">
                    <i class="fas fa-download text-gray-600"></i>
                    <span>Export</span>
                </button>
            </div>
        </div>
        
        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Calculations -->
            <div class="stat-card bg-white p-6 shadow-sm border border-gray-100">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Calculations</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">12,847</p>
                        <div class="flex items-center mt-2">
                            <span class="text-xs trend-up bg-green-50 px-2 py-1 rounded-full">
                                <i class="fas fa-arrow-up mr-1"></i> 12.5%
                            </span>
                            <span class="text-xs text-gray-500 ml-2">vs last month</span>
                        </div>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <i class="fas fa-calculator text-green-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <div class="flex justify-between text-xs text-gray-500">
                        <span>This month</span>
                        <span>1,243</span>
                    </div>
                </div>
            </div>
            
            <!-- Active Users -->
            <div class="stat-card bg-white p-6 shadow-sm border border-gray-100">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Active Users</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">1,847</p>
                        <div class="flex items-center mt-2">
                            <span class="text-xs trend-up bg-green-50 px-2 py-1 rounded-full">
                                <i class="fas fa-arrow-up mr-1"></i> 8.2%
                            </span>
                            <span class="text-xs text-gray-500 ml-2">vs last month</span>
                        </div>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full">
                        <i class="fas fa-users text-blue-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <div class="flex justify-between text-xs text-gray-500">
                        <span>New this month</span>
                        <span>142</span>
                    </div>
                </div>
            </div>
            
            <!-- Avg. Plants/Hectare -->
            <div class="stat-card bg-white p-6 shadow-sm border border-gray-100">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Avg. Plants/Hectare</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">3,128</p>
                        <div class="flex items-center mt-2">
                            <span class="text-xs trend-up bg-green-50 px-2 py-1 rounded-full">
                                <i class="fas fa-arrow-up mr-1"></i> 5.7%
                            </span>
                            <span class="text-xs text-gray-500 ml-2">vs last month</span>
                        </div>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-full">
                        <i class="fas fa-seedling text-purple-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <div class="flex justify-between text-xs text-gray-500">
                        <span>Most efficient</span>
                        <span>Quincunx</span>
                    </div>
                </div>
            </div>
            
            <!-- Success Rate -->
            <div class="stat-card bg-white p-6 shadow-sm border border-gray-100">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Success Rate</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">94.2%</p>
                        <div class="flex items-center mt-2">
                            <span class="text-xs trend-up bg-green-50 px-2 py-1 rounded-full">
                                <i class="fas fa-arrow-up mr-1"></i> 2.3%
                            </span>
                            <span class="text-xs text-gray-500 ml-2">vs last month</span>
                        </div>
                    </div>
                    <div class="bg-yellow-100 p-3 rounded-full">
                        <i class="fas fa-chart-line text-yellow-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <div class="flex justify-between text-xs text-gray-500">
                        <span>Accuracy</span>
                        <span>±1.2%</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Charts and Detailed Analytics -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Planting Methods Chart -->
            <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-semibold text-gray-800">Planting Method Usage</h2>
                    <div class="flex space-x-2">
                        <button class="text-xs bg-gray-100 hover:bg-gray-200 text-gray-700 py-1 px-3 rounded-lg transition-colors">Weekly</button>
                        <button class="text-xs bg-green-500 text-white py-1 px-3 rounded-lg transition-colors">Monthly</button>
                        <button class="text-xs bg-gray-100 hover:bg-gray-200 text-gray-700 py-1 px-3 rounded-lg transition-colors">Yearly</button>
                    </div>
                </div>
                <div class="chart-container" style="height: 300px;">
                    <canvas id="usageChart"></canvas>
                </div>
            </div>
            
            <!-- Method Distribution -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h2 class="text-lg font-semibold text-gray-800 mb-6">Method Distribution</h2>
                <div class="chart-container" style="height: 300px;">
                    <canvas id="distributionChart"></canvas>
                </div>
                <div class="mt-6 grid grid-cols-2 gap-4">
                    <div class="bg-green-50 p-4 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                            <span class="text-sm font-medium text-gray-700">Square</span>
                        </div>
                        <p class="text-xl font-bold text-gray-800 mt-2">56.9%</p>
                    </div>
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-blue-500 rounded-full mr-2"></div>
                            <span class="text-sm font-medium text-gray-700">Quincunx</span>
                        </div>
                        <p class="text-xl font-bold text-gray-800 mt-2">31.3%</p>
                    </div>
                    <div class="bg-yellow-50 p-4 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-yellow-500 rounded-full mr-2"></div>
                            <span class="text-sm font-medium text-gray-700">Triangular</span>
                        </div>
                        <p class="text-xl font-bold text-gray-800 mt-2">18.6%</p>
                    </div>
                    <div class="bg-purple-50 p-4 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-purple-500 rounded-full mr-2"></div>
                            <span class="text-sm font-medium text-gray-700">Other</span>
                        </div>
                        <p class="text-xl font-bold text-gray-800 mt-2">6.8%</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Performance Metrics and Recent Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Performance Metrics -->
            <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h2 class="text-lg font-semibold text-gray-800 mb-6">Performance Metrics</h2>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-3 text-sm font-medium text-gray-500">Planting System</th>
                                <th class="text-left py-3 text-sm font-medium text-gray-500">Calculations</th>
                                <th class="text-left py-3 text-sm font-medium text-gray-500">Growth</th>
                                <th class="text-left py-3 text-sm font-medium text-gray-500">Plants/Hectare</th>
                                <th class="text-left py-3 text-sm font-medium text-gray-500">Efficiency</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-gray-100">
                                <td class="py-4">
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                                        <span class="font-medium text-gray-800">Square System</span>
                                    </div>
                                </td>
                                <td class="py-4">
                                    <span class="font-medium text-gray-800">2,845</span>
                                    <p class="text-xs text-gray-500">This month: 324</p>
                                </td>
                                <td class="py-4">
                                    <span class="text-green-500 font-medium">+12.5%</span>
                                </td>
                                <td class="py-4">
                                    <span class="font-medium text-gray-800">2,500</span>
                                </td>
                                <td class="py-4">
                                    <div class="flex items-center">
                                        <div class="w-16 bg-gray-200 rounded-full h-2 mr-2">
                                            <div class="bg-green-500 h-2 rounded-full" style="width: 85%"></div>
                                        </div>
                                        <span class="text-sm text-gray-700">85%</span>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-b border-gray-100">
                                <td class="py-4">
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 bg-blue-500 rounded-full mr-3"></div>
                                        <span class="font-medium text-gray-800">Quincunx System</span>
                                    </div>
                                </td>
                                <td class="py-4">
                                    <span class="font-medium text-gray-800">1,567</span>
                                    <p class="text-xs text-gray-500">This month: 187</p>
                                </td>
                                <td class="py-4">
                                    <span class="text-green-500 font-medium">+8.2%</span>
                                </td>
                                <td class="py-4">
                                    <span class="font-medium text-gray-800">3,490</span>
                                    <p class="text-xs text-green-500">+15% vs Square</p>
                                </td>
                                <td class="py-4">
                                    <div class="flex items-center">
                                        <div class="w-16 bg-gray-200 rounded-full h-2 mr-2">
                                            <div class="bg-blue-500 h-2 rounded-full" style="width: 78%"></div>
                                        </div>
                                        <span class="text-sm text-gray-700">78%</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-4">
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 bg-yellow-500 rounded-full mr-3"></div>
                                        <span class="font-medium text-gray-800">Triangular System</span>
                                    </div>
                                </td>
                                <td class="py-4">
                                    <span class="font-medium text-gray-800">932</span>
                                    <p class="text-xs text-gray-500">This month: 112</p>
                                </td>
                                <td class="py-4">
                                    <span class="text-green-500 font-medium">+5.7%</span>
                                </td>
                                <td class="py-4">
                                    <span class="font-medium text-gray-800">2,880</span>
                                </td>
                                <td class="py-4">
                                    <div class="flex items-center">
                                        <div class="w-16 bg-gray-200 rounded-full h-2 mr-2">
                                            <div class="bg-yellow-500 h-2 rounded-full" style="width: 72%"></div>
                                        </div>
                                        <span class="text-sm text-gray-700">72%</span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Recent Activity & Insights -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h2 class="text-lg font-semibold text-gray-800 mb-6">Recent Activity & Insights</h2>
                <div class="space-y-4">
                    <div class="flex items-start p-3 bg-green-50 rounded-lg">
                        <div class="bg-green-100 p-2 rounded-full mr-3 mt-1">
                            <i class="fas fa-chart-line text-green-600 text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Square system usage increased by 12.5% this month</p>
                            <p class="text-xs text-gray-500 mt-1">Peak usage on Tuesdays</p>
                        </div>
                    </div>
                    <div class="flex items-start p-3 bg-blue-50 rounded-lg">
                        <div class="bg-blue-100 p-2 rounded-full mr-3 mt-1">
                            <i class="fas fa-users text-blue-600 text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-800">142 new users joined this month</p>
                            <p class="text-xs text-gray-500 mt-1">8.2% growth in active users</p>
                        </div>
                    </div>
                    <div class="flex items-start p-3 bg-yellow-50 rounded-lg">
                        <div class="bg-yellow-100 p-2 rounded-full mr-3 mt-1">
                            <i class="fas fa-seedling text-yellow-600 text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Quincunx system shows 15% higher efficiency</p>
                            <p class="text-xs text-gray-500 mt-1">Popular in commercial farming</p>
                        </div>
                    </div>
                    <div class="flex items-start p-3 bg-purple-50 rounded-lg">
                        <div class="bg-purple-100 p-2 rounded-full mr-3 mt-1">
                            <i class="fas fa-bullseye text-purple-600 text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-800">System accuracy improved to 94.2%</p>
                            <p class="text-xs text-gray-500 mt-1">±1.2% margin of error</p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <h3 class="text-md font-medium text-gray-800 mb-3">Quick Stats</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center p-3 bg-gray-50 rounded-lg">
                            <p class="text-xs text-gray-500">Avg. Session</p>
                            <p class="text-lg font-bold text-gray-800">4.2m</p>
                        </div>
                        <div class="text-center p-3 bg-gray-50 rounded-lg">
                            <p class="text-xs text-gray-500">Bounce Rate</p>
                            <p class="text-lg font-bold text-gray-800">12.4%</p>
                        </div>
                        <div class="text-center p-3 bg-gray-50 rounded-lg">
                            <p class="text-xs text-gray-500">Peak Time</p>
                            <p class="text-lg font-bold text-gray-800">10-11 AM</p>
                        </div>
                        <div class="text-center p-3 bg-gray-50 rounded-lg">
                            <p class="text-xs text-gray-500">Top Region</p>
                            <p class="text-lg font-bold text-gray-800">Europe</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Initialize charts when the page loads
        document.addEventListener('DOMContentLoaded', function() {
            // Usage Trends Chart
            const usageCtx = document.getElementById('usageChart').getContext('2d');
            new Chart(usageCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [
                        {
                            label: 'Square System',
                            data: [220, 235, 210, 255, 280, 275, 290, 310, 295, 320, 335, 350],
                            borderColor: '#10b981',
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            tension: 0.3,
                            fill: true
                        },
                        {
                            label: 'Quincunx System',
                            data: [120, 130, 125, 140, 150, 145, 160, 165, 170, 180, 190, 200],
                            borderColor: '#3b82f6',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            tension: 0.3,
                            fill: true
                        },
                        {
                            label: 'Triangular System',
                            data: [80, 85, 75, 90, 95, 100, 105, 110, 115, 120, 125, 130],
                            borderColor: '#f59e0b',
                            backgroundColor: 'rgba(245, 158, 11, 0.1)',
                            tension: 0.3,
                            fill: true
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                drawBorder: false
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
            
            // Distribution Chart
            const distributionCtx = document.getElementById('distributionChart').getContext('2d');
            new Chart(distributionCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Square System', 'Quincunx System', 'Triangular System', 'Other'],
                    datasets: [{
                        data: [56.9, 31.3, 18.6, 6.8],
                        backgroundColor: [
                            '#10b981',
                            '#3b82f6',
                            '#f59e0b',
                            '#8b5cf6'
                        ],
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    cutout: '70%'
                }
            });
        });
    </script>
</body>
</html>


