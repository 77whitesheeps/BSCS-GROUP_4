@extends('layouts.app')

@section('title', 'Current Weather - Plant-O-Matic')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-cloud-sun text-primary me-2"></i>
                        Current Weather
                    </h1>
                    <p class="text-muted mb-0">Real-time weather information for garden planning</p>
                </div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">Tools</li>
                        <li class="breadcrumb-item active">Current Weather</li>
                    </ol>
                </nav>
            </div>

            <!-- API Setup Instructions -->
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <h6><i class="fas fa-key me-2"></i>🌍 REAL Weather API Setup</h6>
                <p class="mb-2"><strong>Current Status:</strong> Real API configured. Getting live weather data!</p>
                <div class="row">
                    <div class="col-md-8">
                        <ol class="mb-2">
                            <li><strong>Get FREE API Key:</strong> Visit <a href="https://openweathermap.org/api" target="_blank" class="alert-link fw-bold">OpenWeatherMap.org</a></li>
                            <li><strong>Sign up for free</strong> (takes 1 minute)</li>
                            <li><strong>Copy your API key</strong> from your dashboard</li>
                            <li><strong>Replace</strong> <code>'YOUR_API_KEY_HERE'</code> in the JavaScript code with your real key</li>
                        </ol>
                    </div>
                    <div class="col-md-4">
                        <div class="bg-light p-2 rounded">
                            <small class="text-muted">
                                <strong>Benefits of Real API:</strong><br>
                                ✅ Live weather data<br>
                                ✅ Accurate forecasts<br>
                                ✅ Real-time updates<br>
                                ✅ Global coverage
                            </small>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

            <!-- Location Search -->
            <div class="row mb-4">
                <div class="col-md-8 mx-auto">
                    <div class="card shadow">
                        <div class="card-body">
                            <div class="input-group">
                                <input type="text" class="form-control form-control-lg" id="locationInput" 
                                       placeholder="Enter city name (e.g., Manila, Philippines)" value="Manila, Philippines">
                                <button class="btn btn-primary" type="button" onclick="getWeather()">
                                    <i class="fas fa-search me-2"></i>Get Weather
                                </button>
                            </div>
                            <div class="mt-2">
                                <small class="text-muted me-2">Quick locations:</small>
                                <button class="btn btn-outline-secondary btn-sm me-1" onclick="setLocation('Manila, Philippines')">Manila</button>
                                <button class="btn btn-outline-secondary btn-sm me-1" onclick="setLocation('Cebu, Philippines')">Cebu</button>
                                <button class="btn btn-outline-secondary btn-sm me-1" onclick="setLocation('Davao, Philippines')">Davao</button>
                                <button class="btn btn-outline-secondary btn-sm" onclick="setLocation('Baguio, Philippines')">Baguio</button>
                            </div>
                            <div class="form-text">
                                <i class="fas fa-location-crosshairs me-1"></i>
                                Location auto-detected or enter manually. Real weather data only.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Loading State -->
            <div id="loadingState" class="text-center" style="display: none;">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2">Getting weather data...</p>
            </div>

            <!-- Weather Display -->
            <div id="weatherDisplay" style="display: none;">
                <!-- Current Weather Card -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card shadow border-0">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center">
                                            <div class="weather-icon-large me-4">
                                                <i id="weatherIcon" class="fas fa-sun fa-4x text-warning"></i>
                                            </div>
                                            <div>
                                                <h2 id="currentTemp" class="display-4 mb-0">--°C</h2>
                                                <p id="weatherDescription" class="lead mb-0">--</p>
                                                <p id="locationName" class="text-muted mb-0">
                                                    <i class="fas fa-map-marker-alt me-1"></i>--
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row text-center">
                                            <div class="col-6">
                                                <div class="border-end">
                                                    <h5 id="feelsLike" class="mb-1">--°C</h5>
                                                    <small class="text-muted">Feels Like</small>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <h5 id="lastUpdated" class="mb-1">--</h5>
                                                <small class="text-muted">Last Updated</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Weather Details -->
                <div class="row">
                    <!-- Temperature Details -->
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card shadow h-100">
                            <div class="card-header bg-danger text-white">
                                <h6 class="mb-0"><i class="fas fa-thermometer-half me-2"></i>Temperature</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6 text-center">
                                        <h4 id="maxTemp" class="text-danger">--°C</h4>
                                        <small>High</small>
                                    </div>
                                    <div class="col-6 text-center">
                                        <h4 id="minTemp" class="text-info">--°C</h4>
                                        <small>Low</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Humidity -->
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card shadow h-100">
                            <div class="card-header bg-info text-white">
                                <h6 class="mb-0"><i class="fas fa-tint me-2"></i>Humidity</h6>
                            </div>
                            <div class="card-body text-center">
                                <h2 id="humidity" class="text-info mb-2">--%</h2>
                                <div class="progress">
                                    <div id="humidityBar" class="progress-bar bg-info" role="progressbar" style="width: 0%"></div>
                                </div>
                                <small id="humidityLevel" class="text-muted mt-2 d-block">--</small>
                            </div>
                        </div>
                    </div>

                    <!-- Wind -->
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card shadow h-100">
                            <div class="card-header bg-success text-white">
                                <h6 class="mb-0"><i class="fas fa-wind me-2"></i>Wind</h6>
                            </div>
                            <div class="card-body text-center">
                                <h4 id="windSpeed" class="text-success mb-2">-- km/h</h4>
                                <p id="windDirection" class="mb-2">
                                    <i id="windIcon" class="fas fa-location-arrow me-1"></i>--
                                </p>
                                <small id="windLevel" class="text-muted">--</small>
                            </div>
                        </div>
                    </div>

                    <!-- Rainfall/Visibility -->
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card shadow h-100">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0"><i class="fas fa-cloud-rain me-2"></i>Conditions</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <small class="text-muted">Pressure</small>
                                    <h5 id="pressure" class="mb-0">-- hPa</h5>
                                </div>
                                <div class="mb-3">
                                    <small class="text-muted">Visibility</small>
                                    <h5 id="visibility" class="mb-0">-- km</h5>
                                </div>
                                <div>
                                    <small class="text-muted">UV Index</small>
                                    <h5 id="uvIndex" class="mb-0">--</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gardening Tips -->
                <div class="row">
                    <div class="col-12">
                        <div class="card card-dashboard shadow">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-seedling me-2"></i>Gardening Tips Based on Current Weather</h5>
                            </div>
                            <div class="card-body">
                                <div id="gardeningTips" class="row">
                                    <div class="col-12">
                                        <p class="text-center text-muted">Get weather data to see personalized gardening tips...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Error State -->
            <div id="errorState" class="alert alert-danger" style="display: none;" role="alert">
                <h5><i class="fas fa-exclamation-triangle me-2"></i>Error</h5>
                <p id="errorMessage" class="mb-0">Unable to fetch weather data. Please try again.</p>
            </div>
        </div>
    </div>
</div>

<script>
// REAL WEATHER API Configuration
// Get your free API key from: https://openweathermap.org/api
const OPENWEATHER_API_KEY = 'cd7bc3017813205610f4d5480283e9ed'; // Your OpenWeatherMap API key
const OPENWEATHER_BASE_URL = 'https://api.openweathermap.org/data/2.5/weather';
const USE_REAL_API = OPENWEATHER_API_KEY !== 'YOUR_API_KEY_HERE' && OPENWEATHER_API_KEY !== 'demo_key';

// Utility function to safely get DOM elements
function safeGetElement(id) {
    const element = document.getElementById(id);
    if (!element) {
        console.warn(`⚠️ Element with ID '${id}' not found`);
    }
    return element;
}

// Utility function to check if DOM is ready
function isDOMReady() {
    return document.readyState === 'complete' || document.readyState === 'interactive';
}

// Utility function to wait for DOM if needed
function whenDOMReady(callback) {
    if (isDOMReady()) {
        callback();
    } else {
        document.addEventListener('DOMContentLoaded', callback);
    }
}

// Auto-detect location on page load
document.addEventListener('DOMContentLoaded', function() {
    console.log('🌍 WEATHER TOOL LOADED!');
    console.log('🔑 API Key status:', USE_REAL_API ? '✅ REAL API ENABLED' : '❌ NO API KEY');
    console.log('📝 API Key (first 10 chars):', OPENWEATHER_API_KEY.substring(0, 10) + '...');
    
    // Set default location in input (but don't load automatically)
    const locationInput = document.getElementById('locationInput');
    if (locationInput) {
        locationInput.value = 'Manila, Philippines';
        console.log('✅ Default location set in input');
    } else {
        console.warn('⚠️ locationInput element not found in DOMContentLoaded');
    }
    
    // Try geolocation in background (optional, silent)
    tryAutoDetectLocation();
});

// Function to try auto-detecting location (non-blocking)
function tryAutoDetectLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function(position) {
                const lat = position.coords.latitude;
                const lon = position.coords.longitude;
                getWeatherByCoordinates(lat, lon);
            },
            function(error) {
                console.log('Geolocation not available or denied:', error);
                // Keep default location
            },
            { timeout: 2000, maximumAge: 300000 } // 2 second timeout, cache for 5 minutes
        );
    }
}

// Get weather by coordinates (REAL API)
async function getWeatherByCoordinates(lat, lon) {
    if (USE_REAL_API) {
        try {
            showLoading(true);
            const url = `${OPENWEATHER_BASE_URL}?lat=${lat}&lon=${lon}&appid=${OPENWEATHER_API_KEY}&units=metric`;
            const response = await fetch(url);
            
            if (!response.ok) {
                throw new Error(`API Error: ${response.status}`);
            }
            
            const data = await response.json();
            document.getElementById('locationInput').value = `${data.name}, ${data.sys.country}`;
            displayWeather(data);
            generateGardeningTips(data);
            showLoading(false);
        } catch (error) {
            console.error('Real API error:', error);
            showError('Unable to get weather data for your location. Please enter a city manually.');
            showLoading(false);
        }
    } else {
        // No API key configured
        showError('Weather API key is not configured. Please enter a location manually.');
    }
}

// Manual weather search function - REAL API ENABLED
function getWeather() {
    console.log('🔴 GET WEATHER BUTTON CLICKED!');
    
    const locationInput = document.getElementById('locationInput');
    if (!locationInput) {
        console.error('❌ locationInput element not found!');
        showError('Location input not found. Please refresh the page.');
        return;
    }
    
    const location = locationInput.value.trim();
    console.log('📍 Location input value:', location);
    
    if (!location) {
        showError('Please enter a location');
        return;
    }
    
    console.log('🚀 Calling getWeatherData with:', location);
    getWeatherData(location);
}

// Quick location setter function
function setLocation(location) {
    console.log('📍 Quick location selected:', location);
    const locationInput = safeGetElement('locationInput');
    if (locationInput) {
        locationInput.value = location;
        getWeatherData(location);
    } else {
        console.error('❌ Cannot set location - input element not found');
    }
}

// Main weather fetching function - REAL API + FALLBACK
async function getWeatherData(location) {
    console.log('⚡ getWeatherData called with:', location);
    console.log('🔍 USE_REAL_API status:', USE_REAL_API);
    
    hideError();
    hideWeather();
    
    if (USE_REAL_API) {
        // USE REAL OPENWEATHERMAP API
        console.log('🌐 Using REAL API mode');
        try {
            showLoading(true);
            const url = `${OPENWEATHER_BASE_URL}?q=${encodeURIComponent(location)}&appid=${OPENWEATHER_API_KEY}&units=metric`;
            
            console.log('🌍 Fetching real weather data for:', location);
            console.log('📡 API URL:', url);
            
            const response = await fetch(url);
            
            console.log('📊 API Response status:', response.status);
            
            if (!response.ok) {
                const errorData = await response.json().catch(() => ({}));
                console.error('❌ API Error Details:', errorData);
                
                if (response.status === 404) {
                    throw new Error(`City "${location}" not found. Try "Manila, Philippines", "Cebu, Philippines", or "Davao, Philippines".`);
                } else if (response.status === 401) {
                    throw new Error('Invalid API key. Please check your OpenWeatherMap API key.');
                } else if (response.status === 429) {
                    throw new Error('Too many requests. Please wait a moment and try again.');
                } else {
                    throw new Error(`Weather service error: ${response.status} - ${errorData.message || 'Unknown error'}`);
                }
            }
            
            const data = await response.json();
            
            console.log('✅ Real weather data loaded for:', data.name, data.sys.country);
            console.log('🌡️ Temperature:', data.main.temp + '°C');
            console.log('💧 Humidity:', data.main.humidity + '%');
            
            // Display real weather data
            displayWeather(data);
            generateGardeningTips(data);
            
        } catch (error) {
            console.error('🚫 Real API Error:', error);
            console.error('🔍 Error details:', error.message);
            showError(`Weather data unavailable: ${error.message}. Please try a different city or check your spelling.`);
            hideWeather(); // Hide any previously displayed weather
        } finally {
            showLoading(false);
            console.log('🔄 Loading state hidden');
        }
    } else {
        // NO API KEY - Show error instead of demo data
        showError('Weather API key is not configured. Please set up your OpenWeatherMap API key to get real weather data.');
        hideWeather();
    }
}

function displayWeather(data) {
    console.log('🔧 displayWeather called with data:', data);
    
    // Check if all required elements exist
    const requiredElements = ['currentTemp', 'weatherDescription', 'locationName', 'feelsLike', 'lastUpdated'];
    for (const elementId of requiredElements) {
        const element = document.getElementById(elementId);
        if (!element) {
            console.error(`❌ Required element '${elementId}' not found!`);
            return;
        }
    }
    
    // Update main weather info
    document.getElementById('currentTemp').textContent = `${Math.round(data.main.temp)}°C`;
    document.getElementById('weatherDescription').textContent = capitalizeFirst(data.weather[0].description);
    document.getElementById('locationName').textContent = `${data.name}, ${data.sys.country}`;
    document.getElementById('feelsLike').textContent = `${Math.round(data.main.feels_like)}°C`;
    document.getElementById('lastUpdated').textContent = new Date(data.dt * 1000).toLocaleTimeString();

    // Update weather icon
    updateWeatherIcon(data.weather[0].main);

    // Update temperature details
    document.getElementById('maxTemp').textContent = `${Math.round(data.main.temp_max)}°C`;
    document.getElementById('minTemp').textContent = `${Math.round(data.main.temp_min)}°C`;

    // Update humidity
    const humidity = data.main.humidity;
    document.getElementById('humidity').textContent = `${humidity}%`;
    document.getElementById('humidityBar').style.width = `${humidity}%`;
    document.getElementById('humidityLevel').textContent = getHumidityLevel(humidity);

    // Update wind
    const windSpeed = data.wind.speed * 3.6; // Convert m/s to km/h
    document.getElementById('windSpeed').textContent = `${Math.round(windSpeed)} km/h`;
    document.getElementById('windDirection').innerHTML = 
        `<i id="windIcon" class="fas fa-location-arrow me-1" style="transform: rotate(${data.wind.deg}deg);"></i>${getWindDirection(data.wind.deg)}`;
    document.getElementById('windLevel').textContent = getWindLevel(windSpeed);

    // Update other conditions
    document.getElementById('pressure').textContent = `${data.main.pressure} hPa`;
    document.getElementById('visibility').textContent = `${(data.visibility / 1000).toFixed(1)} km`;
    document.getElementById('uvIndex').textContent = 'Moderate'; // Mock UV data

    showWeather();
}

function updateWeatherIcon(weatherMain) {
    const iconElement = document.getElementById('weatherIcon');
    const iconMap = {
        'Clear': { icon: 'fas fa-sun', color: 'text-warning' },
        'Clouds': { icon: 'fas fa-cloud', color: 'text-secondary' },
        'Rain': { icon: 'fas fa-cloud-rain', color: 'text-primary' },
        'Drizzle': { icon: 'fas fa-cloud-rain', color: 'text-info' },
        'Thunderstorm': { icon: 'fas fa-bolt', color: 'text-warning' },
        'Snow': { icon: 'fas fa-snowflake', color: 'text-info' },
        'Mist': { icon: 'fas fa-smog', color: 'text-secondary' },
        'Fog': { icon: 'fas fa-smog', color: 'text-secondary' }
    };

    const weather = iconMap[weatherMain] || iconMap['Clear'];
    iconElement.className = `${weather.icon} fa-4x ${weather.color}`;
}

function generateGardeningTips(data) {
    const temp = data.main.temp;
    const humidity = data.main.humidity;
    const windSpeed = data.wind.speed * 3.6;
    const tips = [];

    // Temperature-based tips
    if (temp < 15) {
        tips.push({
            icon: 'fas fa-temperature-low text-info',
            tip: 'Cool weather - perfect for planting cool-season crops like lettuce, spinach, and peas.'
        });
    } else if (temp > 30) {
        tips.push({
            icon: 'fas fa-temperature-high text-danger',
            tip: 'Hot weather - ensure plants have adequate shade and increase watering frequency.'
        });
    } else {
        tips.push({
            icon: 'fas fa-thermometer-half text-success',
            tip: 'Ideal temperature for most tropical plants. Good time for general gardening activities.'
        });
    }

    // Humidity-based tips
    if (humidity > 80) {
        tips.push({
            icon: 'fas fa-tint text-primary',
            tip: 'High humidity - watch for fungal diseases. Ensure good air circulation around plants.'
        });
    } else if (humidity < 40) {
        tips.push({
            icon: 'fas fa-burn text-warning',
            tip: 'Low humidity - increase watering and consider misting sensitive plants.'
        });
    }

    // Wind-based tips
    if (windSpeed > 25) {
        tips.push({
            icon: 'fas fa-wind text-info',
            tip: 'Strong winds - stake tall plants and check for wind damage. Avoid spraying pesticides.'
        });
    }

    // Weather-specific tips
    if (data.weather[0].main === 'Rain') {
        tips.push({
            icon: 'fas fa-cloud-rain text-primary',
            tip: 'Rainy conditions - good natural watering but ensure proper drainage to prevent root rot.'
        });
    }

    // Display tips
    const tipsContainer = document.getElementById('gardeningTips');
    if (tips.length > 0) {
        tipsContainer.innerHTML = tips.map(tip => `
            <div class="col-md-6 mb-3">
                <div class="d-flex align-items-start">
                    <i class="${tip.icon} me-3 mt-1"></i>
                    <p class="mb-0">${tip.tip}</p>
                </div>
            </div>
        `).join('');
    }
}

function getHumidityLevel(humidity) {
    if (humidity < 30) return 'Low';
    if (humidity < 60) return 'Comfortable';
    if (humidity < 80) return 'High';
    return 'Very High';
}

function getWindLevel(windSpeed) {
    if (windSpeed < 5) return 'Calm';
    if (windSpeed < 15) return 'Light Breeze';
    if (windSpeed < 25) return 'Moderate Breeze';
    if (windSpeed < 40) return 'Strong Breeze';
    return 'Strong Wind';
}

function getWindDirection(degrees) {
    const directions = ['N', 'NNE', 'NE', 'ENE', 'E', 'ESE', 'SE', 'SSE', 'S', 'SSW', 'SW', 'WSW', 'W', 'WNW', 'NW', 'NNW'];
    const index = Math.round(degrees / 22.5) % 16;
    return directions[index];
}

function capitalizeFirst(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
}

function showLoading(show) {
    console.log('🔧 showLoading called with:', show);
    const loadingState = document.getElementById('loadingState');
    console.log('🔍 loadingState element found:', loadingState);
    if (loadingState && loadingState.style) {
        loadingState.style.display = show ? 'block' : 'none';
        console.log('✅ Loading state updated successfully');
    } else {
        console.warn('⚠️ loadingState element not found or has no style property');
    }
}

function showWeather() {
    console.log('🔧 showWeather called');
    const weatherDisplay = document.getElementById('weatherDisplay');
    console.log('🔍 weatherDisplay element found:', weatherDisplay);
    if (weatherDisplay && weatherDisplay.style) {
        weatherDisplay.style.display = 'block';
        console.log('✅ Weather display shown successfully');
    } else {
        console.warn('⚠️ weatherDisplay element not found or has no style property');
    }
}

function hideWeather() {
    console.log('🔧 hideWeather called');
    const weatherDisplay = document.getElementById('weatherDisplay');
    console.log('🔍 weatherDisplay element found:', weatherDisplay);
    if (weatherDisplay && weatherDisplay.style) {
        weatherDisplay.style.display = 'none';
        console.log('✅ Weather display hidden successfully');
    } else {
        console.warn('⚠️ weatherDisplay element not found or has no style property');
    }
}

function showError(message) {
    console.log('🔧 showError called with:', message);
    const errorMessage = document.getElementById('errorMessage');
    const errorState = document.getElementById('errorState');
    
    console.log('🔍 errorMessage element found:', errorMessage);
    console.log('🔍 errorState element found:', errorState);
    
    if (errorMessage) errorMessage.textContent = message;
    if (errorState && errorState.style) {
        errorState.style.display = 'block';
        console.log('✅ Error displayed successfully');
    } else {
        console.warn('⚠️ errorState element not found or has no style property');
    }
}

function hideError() {
    console.log('🔧 hideError called');
    const errorState = document.getElementById('errorState');
    console.log('🔍 errorState element found:', errorState);
    if (errorState && errorState.style) {
        errorState.style.display = 'none';
        console.log('✅ Error hidden successfully');
    } else {
        console.warn('⚠️ errorState element not found or has no style property');
    }
}

// Allow Enter key to trigger weather search
const locationInput = document.getElementById('locationInput');
if (locationInput) {
    locationInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            getWeather();
        }
    });
} else {
    console.warn('⚠️ locationInput element not found');
}

// Console helper for API setup
console.log(`
🌍 PLANT-O-MATIC WEATHER API SETUP:
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

To enable REAL weather data:
1. Visit: https://openweathermap.org/api
2. Sign up for FREE
3. Get your API key
4. Find this line in the code:
   const OPENWEATHER_API_KEY = 'YOUR_API_KEY_HERE';
5. Replace 'YOUR_API_KEY_HERE' with your real key

Current status: ${USE_REAL_API ? '✅ REAL API ENABLED' : '❌ NO API KEY - Configure to get weather data'}
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
`);
</script>

<style>
.weather-icon-large {
    min-width: 80px;
}

.progress {
    height: 8px;
}

@keyframes rotate {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.spinner-border {
    animation: rotate 1s linear infinite;
}

.card {
    transition: transform 0.2s;
}

.card:hover {
    transform: translateY(-2px);
}
</style>
@endsection