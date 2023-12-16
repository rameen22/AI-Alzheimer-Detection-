import keras
import numpy as np
import PIL
import sys
from tensorflow import keras 
from keras.models import load_model
from keras.preprocessing.image import load_img
from keras.preprocessing.image import img_to_array
from keras.preprocessing import image


model = load_model('Alzheimer_PROJECT_CNN.h5')  # Load your pre-trained CNN model

def predict_class(img_path):
    img = image.load_img(img_path, target_size=(32, 32), color_mode='grayscale')
    img = image.img_to_array(img)
    img = np.expand_dims(img, axis=0)
    img = img / 255.0
    predictions = model.predict(img)
    predicted_class_index = np.argmax(predictions)
    class_names = ['MildDemented', 'ModerateDemented', 'NonDemented', 'VeryMildDemented']
    predicted_class = class_names[predicted_class_index]
    return predicted_class 


if __name__ == "__main__":

    
    if len(sys.argv) != 2:
        print("Usage: python model.py <image_path>")
    else:
        image_path = sys.argv[1]
        predicted_class = predict_class(image_path)
        print(predicted_class)