<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome - Room Management System</title>
    <style>
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to right, #00c6ff, #0072ff);
            color: white;
            text-align: center;
            overflow-x: hidden;
            animation: gradientShift 15s ease infinite;
        }

        
        @keyframes gradientShift {
            0% { background: linear-gradient(to right, #00c6ff, #0072ff); }
            50% { background: linear-gradient(to right, #FF6347, #FF4500); }
            100% { background: linear-gradient(to right, #00c6ff, #0072ff); }
        }

        .welcome {
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
            animation: fadeIn 2s ease-out;
        }

        .welcome h1 {
            font-size: 4em;
            margin-bottom: 20px;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.4);
            letter-spacing: 2px;
            animation: textPopUp 1s ease-out;
        }

        .welcome a {
            margin-top: 30px;
            padding: 18px 40px;
            background-color: white;
            color: #0072ff;
            font-weight: bold;
            border-radius: 30px;
            text-decoration: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.4s ease;
            transform: translateY(20px);
            font-size: 1.2em;
        }

        .welcome a:hover {
            background-color: #0056c1;
            color: white;
            transform: translateY(0);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }

        .about {
            background-color: #f8f8f8;
            color: #333;
            padding: 50px 30px;
            margin-top: 50px;
            border-radius: 15px;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            animation: fadeInUp 2s ease-out;
        }

        .about h2 {
            font-size: 2.8em;
            margin-bottom: 20px;
            color: #0072ff;
            animation: bounceIn 1s ease-out;
        }

        .about p {
            font-size: 1.3em;
            line-height: 1.8;
            margin-bottom: 20px;
            animation: fadeInLeft 1.5s ease-out;
        }

        .about h3 {
            font-size: 1.9em;
            margin-bottom: 15px;
        }

        .about ul {
            list-style-type: none;
            padding: 0;
        }

        .about ul li {
            font-size: 1.1em;
            padding: 8px 0;
            animation: fadeInLeft 2s ease-out;
        }

        .about ul li::before {
            content: "• ";
            color: #0072ff;
            font-size: 1.5em;
        }

        
        .particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            width: 10px;
            height: 10px;
            background-color: white;
            border-radius: 50%;
            animation: particleMove 6s linear infinite;
        }

        
        @keyframes particleMove {
            0% {
                transform: translate3d(0, 0, 0);
                opacity: 1;
            }
            100% {
                transform: translate3d(var(--x), var(--y), 0);
                opacity: 0;
            }
        }

        
        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }

        @keyframes fadeInLeft {
            0% { opacity: 0; transform: translateX(-30px); }
            100% { opacity: 1; transform: translateX(0); }
        }

        @keyframes fadeInUp {
            0% { opacity: 0; transform: translateY(30px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        @keyframes textPopUp {
            0% { transform: scale(0.8); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }

        @keyframes bounceIn {
            0% { transform: scale(0); }
            60% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }
    </style>
</head>
<body>

    
    <div class="particles"></div>

    <div class="welcome">
        <h1>Welcome to Room Management System</h1>
        <a href="dashboard.php">Proceed to Dashboard</a>
    </div>

    <div class="about">
        <h2>About Us</h2>
        <p>The goal of this project is to create a system that helps students and teachers identify and locate classrooms and manage occupancy status efficiently. By streamlining room assignments, occupancy tracking, and room status updates, we aim to improve the overall campus experience.</p>
        <h3>Team Members:</h3>
        <ul>
            <li>Angela Gizelle DAYO</li>
            <li>John Marie DIOGRACIAS</li>
            <li>Mike Jhon MARQUEZ</li>
            <li>Jesus Justin MERCADO</li>
            <li>Paul Cedric PASTOR</li>
            <li>Rhendel RICOHERMOSO</li>
        </ul>
    </div>

    <script>
        
        function createParticle() {
            const particle = document.createElement('div');
            particle.classList.add('particle');
            document.querySelector('.particles').appendChild(particle);

            
            particle.style.left = `${Math.random() * 100}%`;
            particle.style.top = `${Math.random() * 100}%`;

            
            particle.style.setProperty('--x', `${Math.random() * 400 - 200}px`);
            particle.style.setProperty('--y', `${Math.random() * 400 - 200}px`);

            
            setTimeout(() => particle.remove(), 6000);
        }

        
        setInterval(createParticle, 100);
    </script>

</body>
</html>
