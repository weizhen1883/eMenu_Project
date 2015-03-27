package com.emenu.zhenw.emenucustomersapp;

import android.content.Context;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.ImageView;
import android.widget.TextView;

import java.util.ArrayList;

/**
 * Created by zhenw on 3/26/15.
 */
public class CuisineAdapter extends ArrayAdapter<MainActivity.MyItem> {

    public CuisineAdapter(Context context, int resource, int textViewResourceId, ArrayList<MainActivity.MyItem> cuisines) {
        super(context, resource, textViewResourceId, cuisines);
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        View view = super.getView(position, convertView, parent);
        TextView cuisineNameView = (TextView) view.findViewById(R.id.cuisineName);
        cuisineNameView.setText(getItem(position).name);
        TextView cuisineIntroView = (TextView) view.findViewById(R.id.cuisineDescription);
        cuisineIntroView.setText(getItem(position).intro);
        TextView cuisinePriceView = (TextView) view.findViewById(R.id.cuisinePrice);
        cuisinePriceView.setText(getItem(position).price);
        ImageView cuisineImageView = (ImageView) view.findViewById(R.id.cuisineImage);
        cuisineImageView.setImageBitmap(getItem(position).image);
        return view;
    }
}
