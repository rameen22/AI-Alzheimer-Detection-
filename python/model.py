import numpy as np
import sys
import keras
import PIL
from tensorflow import keras  # Import TensorFlow's Keras module
from keras.models import load_model
from keras.preprocessing.image import load_img
from keras.preprocessing.image import img_to_array
from keras.preprocessing import image
from skimage.metrics import structural_similarity as ssim  # Import SSIM metric from scikit-image

model = load_model('Alzheimer_PROJECT_CNN.h5')  # Load your pre-trained CNN model

def check_similarity(image1_path, image2_path):
    # Load and resize images, convert to grayscale, and compute SSIM for similarity comparison
    image1 = image.load_img(image1_path, target_size=(32, 32), color_mode='grayscale')
    image2 = image.load_img(image2_path, target_size=(32, 32), color_mode='grayscale')
    similarity = ssim(np.array(image1), np.array(image2))  # Compute SSIM between the images
    return similarity

def predict_class(img_path):
    # Load, preprocess, normalize, and predict the class of the input image using the loaded model
    img = image.load_img(img_path, target_size=(32, 32), color_mode='grayscale')
    img = image.img_to_array(img)
    img = np.expand_dims(img, axis=0)
    img = img / 255.0  # Normalize pixel values
    predictions = model.predict(img)  # Make predictions using the loaded model
    predicted_class_index = np.argmax(predictions)
    class_names = ['MildDemented', 'ModerateDemented', 'NonDemented', 'VeryMildDemented']
    predicted_class = class_names[predicted_class_index]
    return predicted_class

if __name__ == "__main__":
    if len(sys.argv) != 3:
        print("Usage: python model.py <image_path> <reference_mri_path>")
    else:
        image_path = sys.argv[1]
        reference_mri_path = sys.argv[2]

        # Checking similarity with the reference MRI before prediction
        threshold = 0.1 # threshold for similarity comparison

        similarity = check_similarity(image_path, reference_mri_path)  # Calculate similarity

        if similarity < threshold:
            print("INVALID IMAGE: Kindly upload MRI")
        else:
            # Perform prediction on the given image
            predicted_class = predict_class(image_path)
            print(predicted_class)