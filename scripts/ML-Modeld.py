# import pandas as pd
# import itertools
# import json
# import sys

# def suggest_logical_outfits(data):

#     # return 'hello'
#     # return data
#     wardrobe_data = data
#     # return wardrobe_data
#     temp = wardrobe_data[0]['temperature']
#     if temp <= 15:
#         season = "winter"
#     elif 15 < temp <= 25:
#         season = "mid summer"
#     else:
#         season = "summer"

#     data_list = []
#     for item in wardrobe_data:
#         for data_item in item["data"]:
#             data_list.append([data_item["dress_type"], data_item["season_type"], data_item["name"], item["temperature"], data_item["id"]])

#     df = pd.DataFrame(data_list, columns=["dress_type", "season_type", "name", "temperature", "id"])

#     filtered_items = df[df["season_type"].str.lower() == season.lower()]

#     tops = filtered_items[filtered_items["dress_type"].str.contains("top", case=True)]
#     bottoms = filtered_items[filtered_items["dress_type"].str.contains("bottom", case=False)]
#     outerwear = filtered_items[filtered_items["dress_type"].str.contains("outerwear", case=False)]

#     outfit_combinations = []

#     for top, bottom in itertools.product(tops.itertuples(), bottoms.itertuples()):
#         if top.id != bottom.id: 
#             outfit_combinations.append({
#                 "id1": top.id,
#                 "id2": bottom.id,
#                 "name1": top.name,
#                 "name2": bottom.name
#             })

#     for top, bottom, outer in itertools.product(tops.itertuples(), bottoms.itertuples(), outerwear.itertuples()):
#         if top.id != bottom.id and top.id != outer.id and bottom.id != outer.id:
#             outfit_combinations.append({
#                 "id1": top.id,
#                 "id2": bottom.id,
#                 "id3": outer.id,
#                 "name1": top.name,
#                 "name2": bottom.name,
#                 "name3": outer.name
#             })

#     traditional_tops = filtered_items[filtered_items["dress_type"].str.contains("traditional-upper", case=False)]
#     traditional_bottoms = filtered_items[filtered_items["dress_type"].str.contains("traditional-lower", case=False)]

#     for traditional_top, traditional_bottom in itertools.product(traditional_tops.itertuples(), traditional_bottoms.itertuples()):
#         if traditional_top.id != traditional_bottom.id: 
#             outfit_combinations.append({
#                 "id1": traditional_top.id,
#                 "id2": traditional_bottom.id,
#                 "name1": traditional_top.name,
#                 "name2": traditional_bottom.name
#             })

#     for traditional_top, traditional_bottom, outer in itertools.product(traditional_tops.itertuples(), traditional_bottoms.itertuples(), outerwear.itertuples()):
#         if traditional_top.id != traditional_bottom.id and traditional_top.id != outer.id and traditional_bottom.id != outer.id:  # Ensure unique items in the combination
#             outfit_combinations.append({
#                 "id1": traditional_top.id,
#                 "id2": traditional_bottom.id,
#                 "id3": outer.id,
#                 "name1": traditional_top.name,
#                 "name2": traditional_bottom.name,
#                 "name3": outer.name
#             })

#     return outfit_combinations

# data = [
#     {
#         "temperature": 45,
#         "data": [
#             {"dress_type": "top", "season_type": "summer", "name": "T-Shirt A", "id": 1},
#             {"dress_type": "bottom", "season_type": "summer", "name": "Jeans A", "id": 2},
#             {"dress_type": "bottom", "season_type": "summer", "name": "Shorts A", "id": 3},
#             {"dress_type": "top", "season_type": "summer", "name": "Shirt A", "id": 4},
#             {"dress_type": "top", "season_type": "summer", "name": "Sweater A", "id": 5},
#             {"dress_type": "outerwear", "season_type": "summer", "name": "Jacket A", "id": 6},
#             {"dress_type": "traditional-lower", "season_type": "summer", "name": "Shalwar", "id": 7},
#             {"dress_type": "traditional-upper", "season_type": "summer", "name": "Kameez", "id": 8},
#             {"dress_type": "outerwear", "season_type": "summer", "name": "Coat", "id": 9},
#             {"dress_type": "top", "season_type": "summer", "name": "Hoodie A", "id": 10},
#             {"dress_type": "bottom", "season_type": "summer", "name": "Pants A", "id": 11},
#             {"dress_type": "top", "season_type": "summer", "name": "T-Shirt B", "id": 12},
#             {"dress_type": "bottom", "season_type": "summer", "name": "Shorts B", "id": 13},
#             {"dress_type": "top", "season_type": "mid summer", "name": "Hoodie A", "id": 14},
#             {"dress_type": "bottom", "season_type": "mid summer", "name": "Pants A", "id": 15},
#             {"dress_type": "top", "season_type": "mid summer", "name": "T-Shirt B", "id": 16},
#             {"dress_type": "bottom", "season_type": "mid summer", "name": "Shorts B", "id": 17},
#             {"dress_type": "top", "season_type": "winter", "name": "Hoodie A", "id": 18},
#             {"dress_type": "bottom", "season_type": "winter", "name": "Pants A", "id": 19},
#             {"dress_type": "top", "season_type": "winter", "name": "T-Shirt B", "id": 20},
#             {"dress_type": "bottom", "season_type": "winter", "name": "Shorts B", "id": 21}
#         ]
#     }
# ]

# # data = json.dumps(data)

# # logical_outfit_suggestions = suggest_logical_outfits(data)

# # print(f"Outfit suggestions are:")
# # for outfit in logical_outfit_suggestions:
# #     print(outfit)

# # output_file = 'outfit_suggestions.json'
# # with open(output_file, 'w') as file:
# #     json.dump(logical_outfit_suggestions, file, indent=4)

# # print(f"Logical outfit suggestions for Temperature {temp_input} degree celcius have been written to {output_file}.")

# # if __name__ == "__main__":
# #     input_data = sys.argv[1]
# #     wardrobe_data = json.loads(input_data)
# #     print(wardrobe_data)
#     # result = suggest_logical_outfits(input_data)
#     # print(wardrobe_data)
# if __name__ == "__main__":
#     if len(sys.argv) > 1:
#         input_data = sys.argv[1]
#         # print(input_data)
#         wardrobe_data = json.loads(input_data)
#         result= suggest_logical_outfits(wardrobe_data)
#         print(result) 
#         # process_wardrobe_data(input_data)
#     else:
#         print("No input data provided.")

import json
import re
import sys


# Define a function to convert keywords before ':' into '"'
def preprocess_data(data_str):
    # Find all occurrences of <word>:
    matches = re.findall(r'\b(\w+)\s*:', data_str)
    
    # Replace each match with "<match>":
    for match in matches:
        quoted_match = '"' + match + '"'
        data_str = data_str.replace(match, quoted_match, 1)
    
    # Convert the modified string to a Python dictionary
    try:
        data_dict = json.loads(data_str)
        return data_dict
    except json.JSONDecodeError as e:
        print(f"Error decoding JSON: {e}")
        return None



# def process_wardrobe_data(wardrobe_data):
    

    # wardrobe_data = {"temperature":15,"data":[{"dress_type":"top","season_type":"summer","name":"T-Shirt A","id":1},{"dress_type":"bottom","season_type":"summer","name":"Jeans A","id":2},{"dress_type":"bottom","season_type":"summer","name":"Shorts A","id":3},{"dress_type":"top","season_type":"summer","name":"Shirt A","id":4},{"dress_type":"top","season_type":"summer","name":"Sweater A","id":5},{"dress_type":"outerwear","season_type":"summer","name":"Jacket A","id":6},{"dress_type":"traditional-lower","season_type":"summer","name":"Shalwar","id":7},{"dress_type":"traditional-upper","season_type":"summer","name":"Kameez","id":8},{"dress_type":"outerwear","season_type":"summer","name":"Coat","id":9}]}
    # wardrobe_data = json.loads(wardrobe_data)
    # temperature = wardrobe_data[0]["temperature"]
    # data = wardrobe_data[0]["data"]


   


    # # Replace single quotes with double quotes
    # data_str = wardrobe_data.replace("'", '"')
    # print(data_str)


    # Example JSON-formatted string
    # json_string = '{"temperature": 15, "data": [{"dress_type": "top", "season_type": "summer", "name": "T-Shirt A", "id": 1}, {"dress_type": "bottom", "season_type": "summer", "name": "Jeans A", "id": 2}, {"dress_type": "bottom", "season_type": "summer", "name": "Shorts A", "id": 3}, {"dress_type": "top", "season_type": "summer", "name": "Shirt A", "id": 4}, {"dress_type": "top", "season_type": "summer", "name": "Sweater A", "id": 5}, {"dress_type": "outerwear", "season_type": "summer", "name": "Jacket A", "id": 6}, {"dress_type": "traditional-lower", "season_type": "summer", "name": "Shalwar", "id": 7}, {"dress_type": "traditional-upper", "season_type": "summer", "name": "Kameez", "id": 8}, {"dress_type": "outerwear", "season_type": "summer", "name": "Coat", "id": 9}]}'

# Manual parsing (not recommended)
def parse_json_string(json_string):
    stack = []
    i = 0
    current_obj = {}
    key = None
    while i < len(json_string):
        char = json_string[i]
        if char == '{':
            stack.append(current_obj)
            current_obj = {}
        elif char == '}':
            if len(stack) > 0:
                prev_obj = stack.pop()
                if isinstance(prev_obj, list):
                    prev_obj.append(current_obj)
                else:
                    prev_obj[key] = current_obj
                current_obj = prev_obj
        elif char == ':':
            pass
        elif char == ',':
            pass
        elif char == '"':
            if key is None:
                start = i + 1
                i = json_string.find('"', start)
                key = json_string[start:i]
            else:
                start = i + 1
                i = json_string.find('"', start)
                current_obj[key] = json_string[start:i]
                key = None
        i += 1
    return current_obj



if __name__ == "__main__":
    if len(sys.argv) > 1:
        input_data = sys.argv[1]
        # print(input_data)


        input_data = "{temperature:26,data:[{id:1,user_id:1,image:dfd,image_thumbnail:fdf,dress_type:top,season_type:winter,name:a,created_at:null,updated_at:null}]}"
        data= preprocess_data(input_data)
        print("Received JSON:", data) 
        # try:
        #     # Parse JSON string into Python dictionary
        #     wardrobe_data = json.loads(input_data)
            
        #     # Access temperature and data
        #     temperature = wardrobe_data['temperature']
        #     data = wardrobe_data['data']

        #     # Process the data as needed
        #     for item in data:
        #         print(item)  # Example: Print each item for demonstration

        # except json.JSONDecodeError as e:
        #     print(f"Error decoding JSON: {e}")
        # preprocessed_data = preprocess_data(input_data)
        # print(input_data)

#         data = [
#     {
#         "temperature": 45,
#         "data": [
#             {"dress_type": "top", "season_type": "summer", "name": "T-Shirt A", "id": 1},
#             {"dress_type": "bottom", "season_type": "summer", "name": "Jeans A", "id": 2},
#             {"dress_type": "bottom", "season_type": "summer", "name": "Shorts A", "id": 3},
#             {"dress_type": "top", "season_type": "summer", "name": "Shirt A", "id": 4},
#             {"dress_type": "top", "season_type": "summer", "name": "Sweater A", "id": 5},
#             {"dress_type": "outerwear", "season_type": "summer", "name": "Jacket A", "id": 6},
#             {"dress_type": "traditional-lower", "season_type": "summer", "name": "Shalwar", "id": 7},
#             {"dress_type": "traditional-upper", "season_type": "summer", "name": "Kameez", "id": 8},
#             {"dress_type": "outerwear", "season_type": "summer", "name": "Coat", "id": 9},
#             {"dress_type": "top", "season_type": "summer", "name": "Hoodie A", "id": 10},
#             {"dress_type": "bottom", "season_type": "summer", "name": "Pants A", "id": 11},
#             {"dress_type": "top", "season_type": "summer", "name": "T-Shirt B", "id": 12},
#             {"dress_type": "bottom", "season_type": "summer", "name": "Shorts B", "id": 13},
#             {"dress_type": "top", "season_type": "mid summer", "name": "Hoodie A", "id": 14},
#             {"dress_type": "bottom", "season_type": "mid summer", "name": "Pants A", "id": 15},
#             {"dress_type": "top", "season_type": "mid summer", "name": "T-Shirt B", "id": 16},
#             {"dress_type": "bottom", "season_type": "mid summer", "name": "Shorts B", "id": 17},
#             {"dress_type": "top", "season_type": "winter", "name": "Hoodie A", "id": 18},
#             {"dress_type": "bottom", "season_type": "winter", "name": "Pants A", "id": 19},
#             {"dress_type": "top", "season_type": "winter", "name": "T-Shirt B", "id": 20},
#             {"dress_type": "bottom", "season_type": "winter", "name": "Shorts B", "id": 21}
#         ]
#     }
# ]
    #     wardrobe_data = json.loads(input_data)
    #     print(wardrobe_data)
    #     # process_wardrobe_data(input_data)
    # else:
    #     print("No input data provided.")