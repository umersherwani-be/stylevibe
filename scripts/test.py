import re
import json

def preprocess_data(data_str):
    # Find all unquoted keys in the string and quote them
    data_str = re.sub(r'(?<!["\w])(\w+)(?=\s*:)', r'"\1"', data_str)
    
    # Convert the modified string to a Python dictionary
    try:
        data_dict = json.loads(data_str)
        return data_dict
    except json.JSONDecodeError as e:
        print(f"Error decoding JSON: {e}")
        return None

if __name__ == "__main__":
    input_data = {temperature:26,data:[{id:1,user_id:1,image:dfd,image_thumbnail:fdf,dress_type:top,season_type:winter,name:a,created_at:null,updated_at:null}]}")
    data = preprocess_data(input_data)
    print("Received JSON:", data)
    
    
    