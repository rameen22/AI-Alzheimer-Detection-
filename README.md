# AI-Alzheimer-Detection website using deep learning 
Project Description
Alzheimer's Disease Classification from MRI Images
This project aims to develop a neural network model for the accurate classification of Alzheimer's disease stages using Magnetic Resonance Imaging (MRI) scans. Alzheimer's disease progression exhibits distinct stages that can be identified through medical imaging.



Objective:
The primary goal is to create and deploy a deep learning model capable of accurately predicting Alzheimer's disease stages by analyzing MRI scans. The model is designed to categorize scans into different stages: NonDemented, Very Mild Demented, Mild Demented, and Moderate Demented.


                
Key Features:
Data Preparation: Utilize MRI images to build a comprehensive dataset for model training and validation.
Neural Network Model: Implement a deep learning architecture (such as EfficientNetB0) for robust image classification.
Model Training: Train the neural network using labeled MRI images to predict disease progression stages.
Evaluation: Assess model performance using accuracy metrics on test data.
Visualization: Visualize training metrics and insights into the model's learning process.
Deployment: Save the trained model for future use or deployment in clinical settings.
Web Interface: Develop a user-friendly web application to interact with the trained model, allowing users to upload MRI images for disease classification.The web has multiple features like record management of patient ,uploading mri ,generating report etc


Project Structure:
Data Collection: Gather MRI scans with corresponding stage labels.(from kaggle)
Data Processing: Preprocess the images, convert to an appropriate format, and split into training and test sets.
Model Development: Create and train a neural network model on the prepared dataset.
Model Evaluation: Assess the model's accuracy and performance on test data.
Visualization: Display visualizations of training metrics and accuracy for analysis.
Model Deployment: Save the trained model for potential deployment or future use.
Web Interface Development: Design and develop a user-friendly web interface allowing users to upload MRI images and obtain disease classification results.


Technologies Used:
Python
Keras with TensorFlow backend
OpenCV for image processing
cnn for the base model architecture
HTML/CSS/JavaScript/bootstrap for web interface development


Web Interface Details:
The project includes the development of a web interface that enables users to interact with the trained model conveniently. Users can upload MRI images through the interface, and the model will provide predictions regarding Alzheimer's disease stages based on the uploaded images and also can generate report.

Contributions:
Contributions, enhancements, and collaborations are welcome. Fork the repository, make improvements, and create pull requests to further enhance the project.

