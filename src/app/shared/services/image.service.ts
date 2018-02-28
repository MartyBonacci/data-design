import {Injectable} from "@angular/core";
import {Status} from "../classes/status";
import {Image} from "../classes/image";
import {Observable} from "rxjs/Observable";
import {HttpClient} from "@angular/common/http";

@Injectable ()
export class ImageService {

	constructor(protected http : HttpClient ) {}

	//define the API endpoint
	private imageUrl = "api/image/";

	// call to the image API and delete the image in question
	deleteImage(imageId: number) : Observable<Status> {
		return(this.http.delete<Status>(this.imageUrl + imageId));
	}

	// call to the image API and create the image in question
	createImage(image : Image) : Observable<Status> {
		return(this.http.post<Status>(this.imageUrl, image));
	}

	// call to the image API and get a image object based on its Id
	getImage(imageId : number) : Observable<Image> {
		return(this.http.get<Image>(this.imageUrl + imageId));

	}

	// call to the API and get an array of images based off the profileId
	getImageByProfileId(profileId : number) : Observable<Image[]> {
		return(this.http.get<Image[]>(this.imageUrl + profileId));
	}

	// call to the API and get an array of images based off the tweetId
	getImageByTweetId(imageTweetId : number) : Observable<Image[]> {
		return(this.http.get<Image[]>(this.imageUrl + imageTweetId));
	}


}