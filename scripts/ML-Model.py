import pandas as pd
import itertools
import json
import sys

def suggest_logical_outfits(path):
    with open(path, 'r') as file:
        wardrobe_data = json.load(file)
      

    temp = wardrobe_data[0]['temperature']
    if temp <= 15:
        season = "winter"
    elif 15 < temp <= 25:
        season = "mid summer"
    else:
        season = "summer"

    data_list = []
    for item in wardrobe_data:
        for data_item in item["data"]:
            data_list.append([data_item["dress_type"], data_item["season_type"], data_item["name"], item["temperature"], data_item["id"]])

    df = pd.DataFrame(data_list, columns=["dress_type", "season_type", "name", "temperature", "id"])

    filtered_items = df[df["season_type"].str.lower() == season.lower()]

    tops = filtered_items[filtered_items["dress_type"].str.contains("top", case=True)]
    bottoms = filtered_items[filtered_items["dress_type"].str.contains("bottom", case=False)]
    outerwear = filtered_items[filtered_items["dress_type"].str.contains("outerwear", case=False)]

    outfit_combinations = []

    for top, bottom in itertools.product(tops.itertuples(), bottoms.itertuples()):
        if top.id != bottom.id: 
            outfit_combinations.append({
                "id1": top.id,
                "id2": bottom.id,
                "name1": top.name,
                "name2": bottom.name
            })

    for top, bottom, outer in itertools.product(tops.itertuples(), bottoms.itertuples(), outerwear.itertuples()):
        if top.id != bottom.id and top.id != outer.id and bottom.id != outer.id:
            outfit_combinations.append({
                "id1": top.id,
                "id2": bottom.id,
                "id3": outer.id,
                "name1": top.name,
                "name2": bottom.name,
                "name3": outer.name
            })

    traditional_tops = filtered_items[filtered_items["dress_type"].str.contains("traditional-upper", case=False)]
    traditional_bottoms = filtered_items[filtered_items["dress_type"].str.contains("traditional-lower", case=False)]

    for traditional_top, traditional_bottom in itertools.product(traditional_tops.itertuples(), traditional_bottoms.itertuples()):
        if traditional_top.id != traditional_bottom.id: 
            outfit_combinations.append({
                "id1": traditional_top.id,
                "id2": traditional_bottom.id,
                "name1": traditional_top.name,
                "name2": traditional_bottom.name
            })

    for traditional_top, traditional_bottom, outer in itertools.product(traditional_tops.itertuples(), traditional_bottoms.itertuples(), outerwear.itertuples()):
        if traditional_top.id != traditional_bottom.id and traditional_top.id != outer.id and traditional_bottom.id != outer.id:  # Ensure unique items in the combination
            outfit_combinations.append({
                "id1": traditional_top.id,
                "id2": traditional_bottom.id,
                "id3": outer.id,
                "name1": traditional_top.name,
                "name2": traditional_bottom.name,
                "name3": outer.name
            })

    return outfit_combinations


if __name__ == "__main__":
    if len(sys.argv) < 2:
        sys.exit(1)
    path = sys.argv[1]

    combinations = suggest_logical_outfits(path)
    print(json.dumps(combinations, indent=4))
